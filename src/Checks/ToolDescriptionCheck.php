<?php

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * D2: every tool has a description of at least 20 characters: it is the only thing the model reads to pick a tool.
 */
class ToolDescriptionCheck implements WebMcpCheck
{
    use ReadsTools;

    public const int MIN_LENGTH = 20;

    public function run(SiteSnapshot $site): Check
    {
        if (!$site->hasTools()) {
            return Check::skip('D2', 3, 'no_tools');
        }

        // A tool whose name was not readable is a dynamic one: its description is not readable either
        $tools = array_filter($this->tools($site), fn (array $tool): bool => $tool['name'] !== null || $tool['description'] !== null);
        if ($tools === []) {
            return Check::skip('D2', 3, 'unreadable');
        }

        $short = [];
        foreach ($tools as $tool) {
            if (mb_strlen($tool['description'] ?? '') < self::MIN_LENGTH) {
                $short[] = ($tool['name'] ?? '?').': '.($tool['description'] ?? '—');
            }
        }

        return $this->proportional('D2', 3, count($tools), $short, 'short');
    }
}
