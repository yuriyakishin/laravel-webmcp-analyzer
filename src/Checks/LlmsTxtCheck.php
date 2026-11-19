<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * B2: /llms.txt, a short Markdown guide to the site for AI models (llmstxt.org).
 */
class LlmsTxtCheck implements WebMcpCheck
{
    public const string SNIPPET = <<<'MD'
        # Your company

        > One or two sentences: what the site is about and for whom.

        ## Main pages
        - [Services](https://example.com/services): what you offer
        - [Prices](https://example.com/prices): how much it costs
        - [Contact](https://example.com/contact): how to reach you
        MD;

    public function run(SiteSnapshot $site): Check
    {
        if ($site->llms !== null) {
            $files = $site->llmsFull !== null ? ['/llms.txt', '/llms-full.txt'] : ['/llms.txt'];

            return Check::pass('B2', 7, 'found', evidence: $files);
        }

        return $site->llmsFull !== null
            ? Check::warn('B2', 4, 7, 'full_only', evidence: ['/llms-full.txt'], snippet: self::SNIPPET)
            : Check::fail('B2', 7, 'none', snippet: self::SNIPPET);
    }
}
