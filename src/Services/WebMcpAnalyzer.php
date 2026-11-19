<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Services;

use Yu\WebMcpAnalyzer\Checks;
use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\ChecklistReport;

/**
 * Collects a snapshot of the site and runs the checks on it, group by group.
 */
class WebMcpAnalyzer
{
    /**
     * Checks by group, in the order of the report (the report numbers groups 1–4 and checks 01–15 in this order):
     * B — can AI find the site, A — WebMCP tools, D — how clear the tools are, C — security.
     * The letter codes are internal keys of the translations, the report never shows them.
     */
    public const array GROUPS = [
        'B' => [Checks\StructuredDataCheck::class, Checks\LlmsTxtCheck::class, Checks\MetaDescriptionCheck::class, Checks\OpenGraphCheck::class, Checks\RobotsAiBotsCheck::class],
        'A' => [Checks\DeclarativeToolsCheck::class, Checks\ImperativeToolsCheck::class, Checks\FormInputQualityCheck::class],
        'D' => [Checks\ToolNamingCheck::class, Checks\ToolDescriptionCheck::class, Checks\InputSchemaCheck::class, Checks\ToolAnnotationsCheck::class],
        'C' => [Checks\HttpsCheck::class, Checks\ContentSecurityPolicyCheck::class, Checks\MixedContentCheck::class],
    ];

    public function __construct(private SnapshotCollector $collector) {}

    public function analyze(string $url, string $locale): ChecklistReport
    {
        return $this->report($this->collector->collect($url), $locale);
    }

    public function report(SiteSnapshot $site, string $locale): ChecklistReport
    {
        $groups = [];
        foreach (self::GROUPS as $group => $checks) {
            $groups[$group] = array_map(fn (string $check) => app($check)->run($site), $checks);
        }

        return new ChecklistReport(
            url: $site->url,
            locale: $locale,
            checkedAt: now()->toIso8601String(),
            ruleset: (string) config('webmcp-analyzer.ruleset'),
            groups: $groups,
        );
    }
}
