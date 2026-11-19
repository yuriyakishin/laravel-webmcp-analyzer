<?php

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * C2: a Content Security Policy limits what scripts can run on pages that agents interact with.
 */
class ContentSecurityPolicyCheck implements WebMcpCheck
{
    public const string SNIPPET = "Content-Security-Policy: default-src 'self'; script-src 'self'; object-src 'none'; base-uri 'self'; frame-ancestors 'self'";

    public function run(SiteSnapshot $site): Check
    {
        $policy = $site->headers['content-security-policy'] ?? $site->metaCsp;

        if ($policy === null) {
            return Check::warn('C2', 2, 5, 'none', snippet: self::SNIPPET);
        }

        return str_contains($policy, "'unsafe-eval'")
            ? Check::warn('C2', 4, 5, 'unsafe_eval', evidence: [$policy], snippet: self::SNIPPET)
            : Check::pass('C2', 5, 'found', evidence: [$policy]);
    }
}
