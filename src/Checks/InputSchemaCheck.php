<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * D3: the agent knows what to pass: imperative tools have an inputSchema, form fields have types and descriptions.
 */
class InputSchemaCheck implements WebMcpCheck
{
    use ReadsTools;

    public function run(SiteSnapshot $site): Check
    {
        if (!$site->hasTools()) {
            return Check::skip('D3', 2, 'no_tools');
        }

        $total = 0;
        $problems = [];

        foreach ($site->imperativeTools as $tool) {
            if ($tool->name === null && !$tool->hasInputSchema) {
                continue;
            }
            $total++;
            if (!$tool->hasInputSchema) {
                $problems[] = ($tool->name ?? '?').': inputSchema';
            }
        }

        foreach ($site->declarativeTools as $tool) {
            $total++;
            $described = array_filter($tool->fields, fn (array $field): bool => $field['description'] !== null);
            if ($tool->fields === [] || count($described) < count($tool->fields)) {
                $problems[] = ($tool->name ?? '?').': toolparamdescription';
            }
        }

        if ($total === 0) {
            return Check::skip('D3', 2, 'unreadable');
        }

        return $this->proportional('D3', 2, $total, $problems, 'incomplete');
    }
}
