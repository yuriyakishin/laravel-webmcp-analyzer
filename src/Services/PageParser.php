<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Services;

use Dom\Element;
use Dom\HTMLDocument;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Yu\WebMcpAnalyzer\Data\DeclarativeTool;

/**
 * Reads what the checks need from the page HTML with PHP's HTML5 parser.
 */
class PageParser
{
    private HTMLDocument $document;

    public function __construct(string $html, private string $baseUrl, ?string $charset = null)
    {
        $this->document = HTMLDocument::createFromString($html, LIBXML_NOERROR, $charset);
    }

    /**
     * Forms with a toolname attribute; their fields as the browser would turn them into a tool schema.
     *
     * @return list<DeclarativeTool>
     */
    public function declarativeTools(): array
    {
        $tools = [];

        foreach ($this->document->querySelectorAll('form[toolname]') as $form) {
            $fields = [];

            foreach ($form->querySelectorAll('input, select, textarea') as $field) {
                $type = strtolower($field->tagName === 'INPUT' ? ($field->getAttribute('type') ?: 'text') : $field->tagName);

                if (in_array($type, ['hidden', 'submit', 'button', 'reset', 'image'], true)) {
                    continue;
                }

                $fields[] = [
                    'name' => $this->attribute($field, 'name'),
                    'type' => $type,
                    'required' => $field->hasAttribute('required'),
                    'pattern' => $field->hasAttribute('pattern'),
                    'description' => $this->attribute($field, 'toolparamdescription'),
                ];
            }

            $tools[] = new DeclarativeTool(
                name: $this->attribute($form, 'toolname'),
                description: $this->attribute($form, 'tooldescription'),
                autosubmit: $form->hasAttribute('toolautosubmit'),
                fields: $fields,
            );
        }

        return $tools;
    }

    /**
     * Code of the inline <script> elements.
     *
     * @return list<string>
     */
    public function inlineScripts(): array
    {
        $scripts = [];

        foreach ($this->document->querySelectorAll('script:not([src])') as $script) {
            $type = strtolower($script->getAttribute('type') ?? '');

            if (in_array($type, ['', 'module', 'text/javascript', 'application/javascript'], true)) {
                $scripts[] = $script->textContent;
            }
        }

        return $scripts;
    }

    /**
     * Absolute URLs of the external scripts: <script src> and <link rel="modulepreload"> (chunks of Vite and other bundlers).
     *
     * @return list<string>
     */
    public function scriptUrls(): array
    {
        $urls = [];

        foreach ($this->document->querySelectorAll('script[src], link[rel~="modulepreload" i][href]') as $element) {
            $url = $this->absolute($element->getAttribute('src') ?? $element->getAttribute('href') ?? '');
            if ($url !== null) {
                $urls[] = $url;
            }
        }

        return array_values(array_unique($urls));
    }

    /**
     * @return list<array<string, mixed>|null>
     */
    public function jsonLd(): array
    {
        $blocks = [];

        foreach ($this->document->querySelectorAll('script[type="application/ld+json" i]') as $script) {
            $data = json_decode(trim($script->textContent), true);
            $blocks[] = is_array($data) ? $data : null;
        }

        return $blocks;
    }

    public function hasMicrodata(): bool
    {
        return $this->document->querySelector('[itemscope][itemtype]') !== null;
    }

    public function metaDescription(): ?string
    {
        return $this->attribute($this->document->querySelector('meta[name="description" i]'), 'content');
    }

    public function metaCsp(): ?string
    {
        return $this->attribute($this->document->querySelector('meta[http-equiv="content-security-policy" i]'), 'content');
    }

    /**
     * @return array<string, string>
     */
    public function openGraph(): array
    {
        $tags = [];

        foreach ($this->document->querySelectorAll('meta[property^="og:" i]') as $meta) {
            $content = $this->attribute($meta, 'content');
            if ($content !== null) {
                $tags[strtolower($meta->getAttribute('property'))] ??= $content;
            }
        }

        return $tags;
    }

    /**
     * Resources the browser loads over plain http (blocked or warned about on an https page).
     *
     * @return list<string>
     */
    public function insecureResources(): array
    {
        $found = [];
        $selector = 'script[src], img[src], iframe[src], source[src], video[src], audio[src], link[rel~="stylesheet" i][href], link[rel~="icon" i][href]';

        foreach ($this->document->querySelectorAll($selector) as $element) {
            $url = trim($element->getAttribute('src') ?? $element->getAttribute('href') ?? '');
            if (stripos($url, 'http://') === 0) {
                $found[] = $url;
            }
        }

        return array_values(array_unique($found));
    }

    private function absolute(string $url): ?string
    {
        $url = trim($url);
        if ($url === '' || str_starts_with($url, 'data:') || str_starts_with($url, 'javascript:')) {
            return null;
        }

        return (string) UriResolver::resolve(new Uri($this->baseUrl), new Uri($url));
    }

    private function attribute(?Element $element, string $name): ?string
    {
        $value = trim((string) $element?->getAttribute($name));

        return $value === '' ? null : $value;
    }
}
