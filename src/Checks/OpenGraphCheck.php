<?php

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * B4: Open Graph tags that agents and social networks use to describe a link.
 */
class OpenGraphCheck implements WebMcpCheck
{
    public const array TAGS = ['og:title', 'og:description', 'og:type', 'og:url', 'og:image'];

    public const string SNIPPET = <<<'HTML'
        <meta property="og:title" content="Page title">
        <meta property="og:description" content="Short description of the page">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://example.com/page">
        <meta property="og:image" content="https://example.com/preview.jpg">
        HTML;

    public function run(SiteSnapshot $site): Check
    {
        $found = array_values(array_filter(self::TAGS, fn (string $tag): bool => isset($site->openGraph[$tag])));
        $missing = array_values(array_diff(self::TAGS, $found));
        $replace = ['count' => count($found), 'total' => count(self::TAGS), 'missing' => implode(', ', $missing)];

        return match (true) {
            $missing === [] => Check::pass('B4', 5, 'all', $replace, $found),
            $found === [] => Check::fail('B4', 5, 'none', $replace, snippet: self::SNIPPET),
            default => Check::warn('B4', count($found), 5, 'some', $replace, $found, self::SNIPPET),
        };
    }
}
