<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Yu\WebMcpAnalyzer\Livewire\WebMcpAnalyzerComponent;

class WebMcpAnalyzerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/webmcp-analyzer.php', 'webmcp-analyzer');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'webmcp-analyzer');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'webmcp-analyzer');

        // The name is required: without it Livewire 4 makes up a hash and <livewire:webmcp-analyzer /> is not found
        Livewire::component('webmcp-analyzer', WebMcpAnalyzerComponent::class);
    }
}
