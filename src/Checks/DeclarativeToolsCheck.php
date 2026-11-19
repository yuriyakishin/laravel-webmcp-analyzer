<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\DeclarativeTool;
use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * A1: forms that the browser turns into tools (toolname + tooldescription).
 */
class DeclarativeToolsCheck implements WebMcpCheck
{
    public const string SNIPPET = <<<'HTML'
        <form toolname="search_products"
              tooldescription="Search the catalogue by a phrase and show matching products">
            <input name="query" type="search" required
                   toolparamdescription="What the visitor is looking for, e.g. red sneakers">
            <button>Search</button>
        </form>
        HTML;

    public function run(SiteSnapshot $site): Check
    {
        if ($site->declarativeTools === []) {
            return $site->imperativeTools !== []
                ? Check::skip('A1', 15, 'imperative_only')
                : Check::fail('A1', 15, 'none', snippet: self::SNIPPET);
        }

        $names = array_map(fn (DeclarativeTool $tool): string => $tool->name ?? '?', $site->declarativeTools);
        $undescribed = array_filter($site->declarativeTools, fn (DeclarativeTool $tool): bool => $tool->description === null);

        if ($undescribed !== []) {
            return Check::warn('A1', 7, 15, 'no_description', ['count' => count($undescribed)], $names, self::SNIPPET);
        }

        return Check::pass('A1', 15, 'found', ['count' => count($names)], $names);
    }
}
