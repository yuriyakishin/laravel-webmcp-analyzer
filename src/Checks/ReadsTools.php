<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\DeclarativeTool;
use Yu\WebMcpAnalyzer\Data\ImperativeTool;
use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * Shared helpers of the D checks: all tools in one list, and points for the share of tools without a problem.
 */
trait ReadsTools
{
    /**
     * @return list<array{name: ?string, description: ?string}>
     */
    private function tools(SiteSnapshot $site): array
    {
        return [
            ...array_map(fn (DeclarativeTool $tool): array => ['name' => $tool->name, 'description' => $tool->description], $site->declarativeTools),
            ...array_map(fn (ImperativeTool $tool): array => ['name' => $tool->name, 'description' => $tool->description], $site->imperativeTools),
        ];
    }

    /**
     * Full points without problems, none when every item has one, a share of them otherwise.
     *
     * @param  list<string>  $problems
     */
    private function proportional(string $code, int $max, int $total, array $problems, string $note): Check
    {
        if ($problems === []) {
            return Check::pass($code, $max, 'all_good', ['count' => $total]);
        }

        $good = $total - count($problems);
        $replace = ['good' => $good, 'count' => $total];

        return $good === 0
            ? Check::fail($code, $max, $note, $replace, $problems)
            : Check::warn($code, (int) round($max * $good / $total), $max, $note, $replace, $problems);
    }
}
