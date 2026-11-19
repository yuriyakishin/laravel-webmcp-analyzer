<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Data;

/**
 * A <form toolname="..."> on the page: the browser builds a WebMCP tool from it.
 */
final readonly class DeclarativeTool
{
    /**
     * @param  list<array{name: ?string, type: string, required: bool, pattern: bool, description: ?string}>  $fields
     */
    public function __construct(
        public ?string $name,
        public ?string $description,
        public bool $autosubmit,
        public array $fields,
    ) {}
}
