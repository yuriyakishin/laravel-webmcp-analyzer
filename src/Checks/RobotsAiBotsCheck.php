<?php

namespace Yu\WebMcpAnalyzer\Checks;

use Yu\WebMcpAnalyzer\Data\SiteSnapshot;
use Yu\WebToolsCore\Checklist\Check;

/**
 * B5: robots.txt does not shut out the crawlers of AI assistants and AI search.
 */
class RobotsAiBotsCheck implements WebMcpCheck
{
    public const array BOTS = ['GPTBot', 'OAI-SearchBot', 'ChatGPT-User', 'ClaudeBot', 'Claude-User', 'PerplexityBot', 'Google-Extended', 'Applebot-Extended', 'CCBot'];

    public const string SNIPPET = <<<'TXT'
        User-agent: GPTBot
        User-agent: ClaudeBot
        User-agent: PerplexityBot
        User-agent: Google-Extended
        Allow: /
        TXT;

    public function run(SiteSnapshot $site): Check
    {
        if ($site->robots === null) {
            return Check::pass('B5', 5, 'no_robots');
        }

        $groups = $this->groups($site->robots);
        $blocked = array_values(array_filter(self::BOTS, fn (string $bot): bool => $this->isBlocked($bot, $groups)));

        return match (true) {
            $blocked === [] => Check::pass('B5', 5, 'allowed'),
            count($blocked) === count(self::BOTS) => Check::fail('B5', 5, 'all_blocked', evidence: $blocked, snippet: self::SNIPPET),
            default => Check::warn('B5', 3, 5, 'some_blocked', ['count' => count($blocked)], $blocked, self::SNIPPET),
        };
    }

    /**
     * robots.txt as groups: the user agents of a group and whether it closes the whole site.
     *
     * @return list<array{agents: list<string>, blocksAll: bool}>
     */
    private function groups(string $robots): array
    {
        $groups = [];
        $current = null;
        $readingAgents = false;

        foreach (preg_split('~\R~', $robots) as $line) {
            $line = trim(preg_replace('~#.*$~', '', $line));
            if (!str_contains($line, ':')) {
                continue;
            }

            [$field, $value] = array_map(trim(...), explode(':', $line, 2));
            $field = strtolower($field);

            if ($field === 'user-agent') {
                if (!$readingAgents) {
                    $groups[] = ['agents' => [], 'disallowAll' => false, 'allowAll' => false];
                    $current = array_key_last($groups);
                }
                $groups[$current]['agents'][] = strtolower($value);
                $readingAgents = true;

                continue;
            }

            $readingAgents = false;
            if ($current === null) {
                continue;
            }

            if ($field === 'disallow' && $value === '/') {
                $groups[$current]['disallowAll'] = true;
            } elseif ($field === 'allow' && $value === '/') {
                $groups[$current]['allowAll'] = true;
            }
        }

        return array_map(fn (array $group): array => [
            'agents' => $group['agents'],
            'blocksAll' => $group['disallowAll'] && !$group['allowAll'],
        ], $groups);
    }

    /**
     * The bot follows its own group if there is one, otherwise the "*" group (as crawlers do).
     *
     * @param  list<array{agents: list<string>, blocksAll: bool}>  $groups
     */
    private function isBlocked(string $bot, array $groups): bool
    {
        $own = array_filter($groups, fn (array $group): bool => in_array(strtolower($bot), $group['agents'], true));
        $applied = $own !== [] ? $own : array_filter($groups, fn (array $group): bool => in_array('*', $group['agents'], true));

        foreach ($applied as $group) {
            if ($group['blocksAll']) {
                return true;
            }
        }

        return false;
    }
}
