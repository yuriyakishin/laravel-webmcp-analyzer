<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * D1: tool names follow the spec (1–128 of a–z, 0–9, "_", "-", ".") and say what the tool does.
 */
class ToolNamingCheck implements WebMcpCheck
{
    use ReadsTools;

    private const array GENERIC = ['form', 'tool', 'test', 'submit', 'send', 'action', 'untitled', 'default', 'main'];

    public function run(SiteSnapshot $site): Check
    {
        if (!$site->hasTools()) {
            return Check::skip('D1', 3, 'no_tools');
        }

        $names = array_values(array_filter(array_column($this->tools($site), 'name')));
        if ($names === []) {
            return Check::skip('D1', 3, 'unreadable');
        }

        $bad = array_values(array_filter($names, fn (string $name): bool => !$this->isGood($name)));

        return $this->proportional('D1', 3, count($names), $bad, 'bad_names');
    }

    private function isGood(string $name): bool
    {
        return preg_match('~^[A-Za-z0-9_.-]{3,128}$~', $name) === 1
            && !in_array(strtolower(preg_replace('~\d+$~', '', $name)), self::GENERIC, true);
    }
}
