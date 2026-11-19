<?php

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * C3: an https page loads nothing over plain http (browsers block or flag such resources).
 */
class MixedContentCheck implements WebMcpCheck
{
    public function run(SiteSnapshot $site): Check
    {
        if (!$site->isHttps()) {
            return Check::skip('C3', 5, 'not_https');
        }

        return $site->insecureResources === []
            ? Check::pass('C3', 5, 'none')
            : Check::fail('C3', 5, 'found', ['count' => count($site->insecureResources)], array_slice($site->insecureResources, 0, 10));
    }
}
