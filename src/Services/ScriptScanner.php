<?php

namespace Yu\WebMcpAnalyzer\Services;

use Yu\WebMcpAnalyzer\Data\ImperativeTool;

/**
 * Finds WebMCP registerTool() calls in JavaScript source (minified bundles too) without running it.
 * Reads the top level of the object literal passed to the call, so "description" keys inside inputSchema
 * are not mistaken for the tool's description. Anything built at run time comes back as null.
 */
class ScriptScanner
{
    public const array ANNOTATIONS = ['readOnlyHint', 'untrustedContentHint', 'destructiveHint', 'idempotentHint', 'openWorldHint'];

    /**
     * @return list<ImperativeTool>
     */
    public function tools(string $code, string $source): array
    {
        if (!str_contains($code, 'modelContext') || !str_contains($code, 'registerTool')) {
            return [];
        }

        $tools = [];
        $offset = 0;

        while (($position = strpos($code, 'registerTool(', $offset)) !== false) {
            $start = $position + strlen('registerTool(');
            $offset = $start;
            $literal = $this->objectLiteral($code, $start);

            if ($literal === null) {
                // registerTool(tool): the descriptor is a variable, its fields are not readable statically
                $tools[] = new ImperativeTool(null, null, false, false, [], $source);

                continue;
            }

            $topLevel = $this->topLevel($literal);

            $tools[] = new ImperativeTool(
                name: $this->stringValue($topLevel, 'name'),
                description: $this->stringValue($topLevel, 'description'),
                hasInputSchema: (bool) preg_match('~(?:^|[{,\s])["\']?inputSchema["\']?\s*:~', $topLevel),
                schemaHasProperties: (bool) preg_match('~["\']?properties["\']?\s*:\s*\{\s*["\'\w$]~', $literal),
                annotations: array_values(array_filter(self::ANNOTATIONS, fn (string $hint): bool => str_contains($literal, $hint))),
                source: $source,
            );
        }

        return $tools;
    }

    /**
     * navigator.modelContext is the old location of the API (moved to document.modelContext in 2026).
     */
    public function usesDeprecatedApi(string $code): bool
    {
        return str_contains($code, 'navigator.modelContext') && !str_contains($code, 'document.modelContext');
    }

    /**
     * The "{...}" literal starting at $start (whitespace allowed before it), or null when the argument is not a literal.
     */
    private function objectLiteral(string $code, int $start): ?string
    {
        $length = strlen($code);
        $i = $start;

        while ($i < $length && ctype_space($code[$i])) {
            $i++;
        }

        if (($code[$i] ?? '') !== '{') {
            return null;
        }

        $depth = 0;
        $quote = null;

        for ($j = $i; $j < $length && $j - $i < 20000; $j++) {
            $char = $code[$j];

            if ($quote !== null) {
                if ($char === '\\') {
                    $j++;
                } elseif ($char === $quote) {
                    $quote = null;
                }

                continue;
            }

            if ($char === '"' || $char === "'" || $char === '`') {
                $quote = $char;
            } elseif ($char === '{') {
                $depth++;
            } elseif ($char === '}' && --$depth === 0) {
                return substr($code, $i, $j - $i + 1);
            }
        }

        return null;
    }

    /**
     * The literal with every nested {...} and [...] removed: only the keys of the descriptor itself stay.
     */
    private function topLevel(string $literal): string
    {
        $out = '';
        $depth = 0;
        $quote = null;
        $length = strlen($literal);

        for ($i = 0; $i < $length; $i++) {
            $char = $literal[$i];

            if ($quote !== null) {
                if ($depth <= 1) {
                    $out .= $char;
                }
                if ($char === '\\') {
                    if ($depth <= 1 && $i + 1 < $length) {
                        $out .= $literal[$i + 1];
                    }
                    $i++;
                } elseif ($char === $quote) {
                    $quote = null;
                }

                continue;
            }

            if ($char === '"' || $char === "'" || $char === '`') {
                $quote = $char;
            } elseif ($char === '{' || $char === '[') {
                $depth++;
                if ($depth === 1) {
                    continue;
                }
            } elseif ($char === '}' || $char === ']') {
                $depth--;

                continue;
            }

            if ($depth <= 1) {
                $out .= $char;
            }
        }

        return $out;
    }

    /**
     * The value of `key: "text"` (any quotes); null when it is missing or built at run time.
     */
    private function stringValue(string $topLevel, string $key): ?string
    {
        $pattern = '~(?:^|[,\s])["\']?'.$key.'["\']?\s*:\s*(["\'`])((?:\\\\.|(?!\1).)*)\1~s';

        if (!preg_match($pattern, $topLevel, $match) || str_contains($match[2], '${')) {
            return null;
        }

        return stripcslashes($match[2]);
    }
}
