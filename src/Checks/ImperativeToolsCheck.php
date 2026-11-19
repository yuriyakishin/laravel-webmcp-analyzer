<?php

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\ImperativeTool;
use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * A2: tools registered from JavaScript with document.modelContext.registerTool().
 */
class ImperativeToolsCheck implements WebMcpCheck
{
    public const string SNIPPET = <<<'JS'
        if ('modelContext' in document) {
            document.modelContext.registerTool({
                name: 'get_order_status',
                description: 'Returns the delivery status of an order by its number',
                inputSchema: {
                    type: 'object',
                    properties: { order: { type: 'string', description: 'Order number, e.g. 10452' } },
                    required: ['order'],
                },
                annotations: { readOnlyHint: true },
                async execute({ order }) {
                    const response = await fetch(`/api/orders/${order}/status`);
                    return JSON.stringify(await response.json());
                },
            });
        }
        JS;

    public function run(SiteSnapshot $site): Check
    {
        if ($site->imperativeTools === []) {
            return $site->declarativeTools !== []
                ? Check::skip('A2', 15, 'declarative_only')
                : Check::fail('A2', 15, 'none', ['scripts' => $site->scriptsChecked], snippet: self::SNIPPET);
        }

        $names = array_map(fn (ImperativeTool $tool): string => ($tool->name ?? '(dynamic)').' — '.$tool->source, $site->imperativeTools);

        if ($site->usesDeprecatedApi) {
            return Check::warn('A2', 7, 15, 'deprecated', ['count' => count($names)], $names, self::SNIPPET);
        }

        return Check::pass('A2', 15, 'found', ['count' => count($names)], $names);
    }
}
