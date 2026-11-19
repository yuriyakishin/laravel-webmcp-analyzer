<?php

namespace Yu\WebMcpAnalyzer\Services;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Exceptions\ToolException;
use Yu\WebToolsCore\Http\Resource;
use Yu\WebToolsCore\Http\SafeFetcher;

/**
 * Downloads the page, the site's own scripts, robots.txt and llms.txt once, and reads them into a SiteSnapshot.
 * Only the page is required: a script or a text file that fails to load just stays out of the snapshot.
 */
class SnapshotCollector
{
    private const array HTML = ['text/html', 'application/xhtml+xml'];

    private const array SCRIPT = ['javascript', 'ecmascript'];

    public function __construct(private SafeFetcher $fetcher, private ScriptScanner $scanner) {}

    /**
     * @throws ToolException when the page itself cannot be loaded
     */
    public function collect(string $url): SiteSnapshot
    {
        $page = $this->fetcher->fetch($url, self::HTML, $this->limit('page_bytes'), 'text/html,application/xhtml+xml');

        if ($page->status !== 200) {
            throw new ToolException('http_error', ['status' => $page->status]);
        }

        $parser = new PageParser($page->body, $page->url, $page->charset);

        $scripts = array_map(fn (string $code): array => ['code' => $code, 'source' => 'inline'], $parser->inlineScripts());
        foreach ($this->siteScripts($parser->scriptUrls(), $page->url) as $script) {
            $scripts[] = ['code' => $script->body, 'source' => $script->url];
        }

        $imperativeTools = [];
        $deprecated = false;
        foreach ($scripts as $script) {
            array_push($imperativeTools, ...$this->scanner->tools($script['code'], $script['source']));
            $deprecated = $deprecated || $this->scanner->usesDeprecatedApi($script['code']);
        }

        $origin = $this->origin($page->url);

        return new SiteSnapshot(
            url: $page->url,
            headers: $page->headers,
            declarativeTools: $parser->declarativeTools(),
            imperativeTools: $imperativeTools,
            usesDeprecatedApi: $deprecated,
            scriptsChecked: count($scripts),
            robots: $this->textFile($origin.'/robots.txt'),
            llms: $this->textFile($origin.'/llms.txt'),
            llmsFull: $this->textFile($origin.'/llms-full.txt'),
            jsonLd: $parser->jsonLd(),
            hasMicrodata: $parser->hasMicrodata(),
            metaDescription: $parser->metaDescription(),
            openGraph: $parser->openGraph(),
            insecureResources: str_starts_with($page->url, 'https://') ? $parser->insecureResources() : [],
            metaCsp: $parser->metaCsp(),
        );
    }

    /**
     * Scripts of the same site (third-party analytics and CDNs do not register the site's tools), within the limits.
     *
     * @param  list<string>  $urls
     * @return list<resource>
     */
    private function siteScripts(array $urls, string $pageUrl): array
    {
        $site = $this->siteDomain($pageUrl);
        $scripts = [];
        $total = 0;

        foreach ($urls as $url) {
            $host = strtolower((string) parse_url($url, PHP_URL_HOST));

            if (count($scripts) >= $this->limit('max_scripts') || ($host !== $site && !str_ends_with($host, '.'.$site))) {
                continue;
            }

            try {
                $script = $this->fetcher->fetch($url, self::SCRIPT, $this->limit('script_bytes'), 'application/javascript,*/*;q=0.1');
            } catch (ToolException) {
                continue;
            }

            $total += strlen($script->body);
            if ($script->status !== 200 || $total > $this->limit('total_script_bytes')) {
                continue;
            }

            $scripts[] = $script;
        }

        return $scripts;
    }

    /**
     * The body of a text file such as robots.txt; null when it is missing. Many sites answer a missing file
     * with their HTML 404 page and status 200, so an HTML answer counts as missing too.
     */
    private function textFile(string $url): ?string
    {
        try {
            $file = $this->fetcher->fetch($url, null, $this->limit('text_bytes'), 'text/plain,*/*;q=0.1');
        } catch (ToolException) {
            return null;
        }

        $body = trim($file->body);
        $looksLikeHtml = str_contains($file->contentType, 'html') || stripos(ltrim($body), '<!doctype') === 0 || stripos(ltrim($body), '<html') === 0;

        return $file->status === 200 && $body !== '' && !$looksLikeHtml ? $body : null;
    }

    private function origin(string $url): string
    {
        $parts = parse_url($url);

        return $parts['scheme'].'://'.$parts['host'].(isset($parts['port']) ? ':'.$parts['port'] : '');
    }

    /**
     * "www.shop.com" and "shop.com" are one site; scripts from its subdomains (static.shop.com) belong to it.
     */
    private function siteDomain(string $url): string
    {
        return preg_replace('~^www\.~', '', strtolower((string) parse_url($url, PHP_URL_HOST)));
    }

    private function limit(string $name): int
    {
        return (int) config('webmcp-analyzer.fetch.'.$name);
    }
}
