<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Livewire;

use Illuminate\Contracts\View\View;
use Yu\WebMcpAnalyzer\Events\WebMcpAnalyzerEvent;
use Yu\WebMcpAnalyzer\Services\WebMcpAnalyzer;
use Yu\WebToolsCore\Livewire\ToolComponent;
use Yu\WebToolsCore\Locale\LocaleResolver;

/**
 * The WebMCP readiness check: the form, the loading log and the checklist report.
 */
class WebMcpAnalyzerComponent extends ToolComponent
{
    protected function name(): string
    {
        return 'webmcp-analyzer';
    }

    protected function event(): string
    {
        return WebMcpAnalyzerEvent::class;
    }

    protected function locales(): LocaleResolver
    {
        return new LocaleResolver(dirname(__DIR__, 2).'/resources/lang');
    }

    protected function run(string $url, string $locale): array
    {
        return app(WebMcpAnalyzer::class)->analyze($url, $locale)->toArray();
    }

    public function render(): View
    {
        return view('webmcp-analyzer::webmcp-analyzer');
    }
}
