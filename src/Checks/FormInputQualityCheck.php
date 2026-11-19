<?php

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * A3: fields of tool forms that an agent can fill in correctly: a name, a real type and a description.
 */
class FormInputQualityCheck implements WebMcpCheck
{
    public const string SNIPPET = <<<'HTML'
        <input name="email" type="email" required
               toolparamdescription="Customer email for the order confirmation">
        HTML;

    public function run(SiteSnapshot $site): Check
    {
        if ($site->declarativeTools === []) {
            return Check::skip('A3', 10, 'no_forms');
        }

        $total = 0;
        $problems = [];

        foreach ($site->declarativeTools as $tool) {
            foreach ($tool->fields as $field) {
                $total++;
                $missing = array_keys(array_filter([
                    'name' => $field['name'] === null,
                    'toolparamdescription' => $field['description'] === null,
                ]));

                if ($missing !== []) {
                    $problems[] = ($tool->name ?? '?').' → '.($field['name'] ?? $field['type']).': '.implode(', ', $missing);
                }
            }
        }

        if ($total === 0) {
            return Check::warn('A3', 5, 10, 'no_fields');
        }

        $good = $total - count($problems);
        $points = (int) round(10 * $good / $total);

        return match (true) {
            $problems === [] => Check::pass('A3', 10, 'all_good', ['count' => $total]),
            $points >= 4 => Check::warn('A3', $points, 10, 'some_missing', ['good' => $good, 'count' => $total], $problems, self::SNIPPET),
            default => Check::fail('A3', 10, 'most_missing', ['good' => $good, 'count' => $total], $problems, self::SNIPPET),
        };
    }
}
