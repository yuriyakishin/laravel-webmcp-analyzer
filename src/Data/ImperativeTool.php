<?php

declare(strict_types=1);

namespace Yu\WebMcpAnalyzer\Data;

/**
 * A registerTool() call found in the page scripts. Found by reading the code, not by running it:
 * a name or description built at run time is null.
 */
final readonly class ImperativeTool
{
    /**
     * @param  list<string>  $annotations  e.g. ['readOnlyHint']
     */
    public function __construct(
        public ?string $name,
        public ?string $description,
        public bool $hasInputSchema,
        public bool $schemaHasProperties,
        public array $annotations,
        public string $source,
    ) {}
}
