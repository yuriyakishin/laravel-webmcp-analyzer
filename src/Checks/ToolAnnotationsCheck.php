<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * D4: imperative tools declare hints such as readOnlyHint, so an agent knows which tools change data.
 */
class ToolAnnotationsCheck implements WebMcpCheck
{
    use ReadsTools;

    public function run(SiteSnapshot $site): Check
    {
        $tools = array_filter($site->imperativeTools, fn ($tool): bool => $tool->name !== null || $tool->hasInputSchema);

        if ($tools === []) {
            return Check::skip('D4', 2, $site->hasTools() ? 'declarative_only' : 'no_tools');
        }

        $missing = [];
        foreach ($tools as $tool) {
            if ($tool->annotations === []) {
                $missing[] = $tool->name ?? '?';
            }
        }

        return $this->proportional('D4', 2, count($tools), $missing, 'missing');
    }
}
