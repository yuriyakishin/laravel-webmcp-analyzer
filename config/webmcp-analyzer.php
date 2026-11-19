<?php

declare(strict_types=1);

return [
    'enabled' => env('WEBMCP_ANALYZER_ENABLED', true),

    /* Version of the scoring rules shown under the score; change it when the checks or points change. */
    'ruleset' => '2026-11-13',

    'fetch' => [
        'page_bytes' => 2 * 1024 * 1024,
        'max_scripts' => 10,
        'script_bytes' => 1024 * 1024,
        'total_script_bytes' => 3 * 1024 * 1024,
        'text_bytes' => 256 * 1024,
    ],

    'rate_limit' => [
        'per_hour' => (int) env('WEBMCP_ANALYZER_PER_HOUR', 10),
    ],

    /* The check is rule-based and free, so a short cache: repeated clicks are instant, fixes show up soon. */
    'cache' => [
        'ttl' => 600,
    ],
];
