<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * B1: Schema.org data that tells AI models what the page and the business are.
 */
class StructuredDataCheck implements WebMcpCheck
{
    public const string SNIPPET = <<<'HTML'
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "Your company",
          "url": "https://example.com",
          "description": "What you do, for whom and where"
        }
        </script>
        HTML;

    public function run(SiteSnapshot $site): Check
    {
        $valid = array_values(array_filter($site->jsonLd));
        $types = array_values(array_unique(array_merge(...array_map($this->types(...), $valid))));

        if ($valid !== []) {
            return Check::pass('B1', 8, 'json_ld', ['count' => count($valid)], $types);
        }

        if ($site->jsonLd !== []) {
            return Check::fail('B1', 8, 'invalid_json', snippet: self::SNIPPET);
        }

        return $site->hasMicrodata
            ? Check::warn('B1', 4, 8, 'microdata_only', snippet: self::SNIPPET)
            : Check::fail('B1', 8, 'none', snippet: self::SNIPPET);
    }

    /**
     * "@type" values of a block and of its "@graph" items.
     *
     * @param  array<string, mixed>  $block
     * @return list<string>
     */
    private function types(array $block): array
    {
        $items = isset($block['@graph']) && is_array($block['@graph']) ? $block['@graph'] : [$block];
        $types = [];

        foreach ($items as $item) {
            foreach ((array) ($item['@type'] ?? []) as $type) {
                if (is_string($type)) {
                    $types[] = $type;
                }
            }
        }

        return $types;
    }
}
