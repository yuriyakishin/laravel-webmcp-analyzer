<?php

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * C1: the page is served over HTTPS; WebMCP, like most new browser APIs, works only in a secure context.
 */
class HttpsCheck implements WebMcpCheck
{
    public function run(SiteSnapshot $site): Check
    {
        return $site->isHttps()
            ? Check::pass('C1', 10, 'https', evidence: [$site->url])
            : Check::fail('C1', 10, 'http', evidence: [$site->url]);
    }
}
