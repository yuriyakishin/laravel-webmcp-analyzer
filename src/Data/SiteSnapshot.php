<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Data;

/**
 * Everything the checks need, collected once per check: the checks themselves never touch the network.
 */
final readonly class SiteSnapshot
{
    /**
     * @param  array<string, string>  $headers  page response headers, names in lower case
     * @param  list<DeclarativeTool>  $declarativeTools
     * @param  list<ImperativeTool>  $imperativeTools
     * @param  list<array<string, mixed>|null>  $jsonLd  decoded JSON-LD blocks; null for a block that is not valid JSON
     * @param  array<string, string>  $openGraph  og:* properties found, e.g. ['og:title' => '...']
     * @param  list<string>  $insecureResources  http:// resources on an https page
     */
    public function __construct(
        public string $url,
        public array $headers,
        public array $declarativeTools = [],
        public array $imperativeTools = [],
        public bool $usesDeprecatedApi = false,
        public int $scriptsChecked = 0,
        public ?string $robots = null,
        public ?string $llms = null,
        public ?string $llmsFull = null,
        public array $jsonLd = [],
        public bool $hasMicrodata = false,
        public ?string $metaDescription = null,
        public array $openGraph = [],
        public array $insecureResources = [],
        public ?string $metaCsp = null,
    ) {}

    public function isHttps(): bool
    {
        return str_starts_with(strtolower($this->url), 'https://');
    }

    public function hasTools(): bool
    {
        return $this->declarativeTools !== [] || $this->imperativeTools !== [];
    }
}
