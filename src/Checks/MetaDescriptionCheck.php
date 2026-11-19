<?php

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * B3: a meta description that summarises the page, 50–160 characters.
 */
class MetaDescriptionCheck implements WebMcpCheck
{
    public const array RANGE = [50, 160];

    public const string SNIPPET = '<meta name="description" content="What this page offers, for whom, and why it is worth opening — in 50–160 characters.">';

    public function run(SiteSnapshot $site): Check
    {
        if ($site->metaDescription === null) {
            return Check::fail('B3', 5, 'none', snippet: self::SNIPPET);
        }

        $length = mb_strlen($site->metaDescription);
        $replace = ['length' => $length, 'min' => self::RANGE[0], 'max' => self::RANGE[1]];

        return $length >= self::RANGE[0] && $length <= self::RANGE[1]
            ? Check::pass('B3', 5, 'good', $replace, [$site->metaDescription])
            : Check::warn('B3', 3, 5, 'length', $replace, [$site->metaDescription], self::SNIPPET);
    }
}
