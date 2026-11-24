<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Events;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * A visitor ran a check in WebMCP Analyzer: fired for every finished check, from the cache too, and for failed ones.
 * Fired next to Yu\WebToolsCore\Events\ToolCheckedEvent, so a listener can subscribe to this one tool only.
 */
class WebMcpAnalyzerEvent
{
    use Dispatchable;

    /**
     * @param  string  $url  the checked address after normalisation
     * @param  string  $locale  language of the tool for this visitor
     * @param  array<string, mixed>|null  $report  the report array; null when the check failed
     * @param  string|null  $error  reason of the failure, e.g. "timeout" or "rate_limited"; null on success
     * @param  bool  $fromCache  the report was taken from the cache, no new check was made
     */
    public function __construct(
        public readonly string $url,
        public readonly string $locale,
        public readonly ?array $report = null,
        public readonly ?string $error = null,
        public readonly bool $fromCache = false,
    ) {}
}
