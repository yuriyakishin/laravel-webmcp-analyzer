@php($t = fn (string $key, array $replace = []) => __('webmcp-analyzer::messages.'.$key, $replace, $locale))

<div class="wt" lang="{{ $locale }}" x-data="{
        step: 0,
        timer: null,
        start() { this.step = 0; clearInterval(this.timer); this.timer = setInterval(() => this.step = Math.min(this.step + 1, 3), 1200) },
        again() { this.$refs.form.scrollIntoView({ behavior: 'smooth', block: 'center' }); this.$refs.url.focus({ preventScroll: true }); this.$refs.url.select() },
    }" @wt-again="again()">
    <form class="wt-tool" wire:submit="analyze" @submit="start()" x-ref="form" novalidate>
        <div class="wt-row">
            <div @class(['wt-field', 'wt-field-err' => $errors->has('url')])>
                <input id="wt-url" type="text" inputmode="url" autocomplete="url" placeholder=" "
                       wire:model="url" x-ref="url">
                <label for="wt-url">{{ $t('form.label') }}</label>
            </div>
            <button type="submit" class="wt-go" wire:loading.attr="disabled" wire:target="analyze">
                <span wire:loading.remove wire:target="analyze">{{ $t('form.button') }}</span>
                <span wire:loading wire:target="analyze" class="wt-spin" aria-hidden="true"></span>
            </button>
        </div>
        <p class="wt-hint">{{ $t('form.hint', ['count' => config('webmcp-analyzer.rate_limit.per_hour')]) }}</p>
        @error('url')<p class="wt-error">{{ $message }}</p>@enderror
        @if ($error)
            <p class="wt-error" role="alert">{{ $error }}</p>
        @endif
    </form>

    {{-- Lines light up on a timer while one request runs; the server does not report its steps --}}
    <div class="wt-log" wire:loading.block wire:target="analyze" aria-hidden="true">
        @foreach (['page', 'scripts', 'files', 'checks'] as $i => $line)
            <p :class="{ 'wt-run': step === {{ $i }}, 'wt-done': step > {{ $i }} }">{{ $t('loading.'.$line) }}</p>
        @endforeach
    </div>

    @if ($report)
        <div wire:loading.remove wire:target="analyze" aria-live="polite">
            @include('web-tools-core::checklist-report', ['report' => $report, 'tool' => 'webmcp-analyzer', 'locale' => $locale])
        </div>
    @endif
</div>
