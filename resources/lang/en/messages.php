<?php

return [
    'form' => [
        'label' => 'Page address',
        'button' => 'Check',
        'hint' => 'Free · no sign-up · up to :count checks per hour',
    ],
    'loading' => [
        'page' => 'Scanning the page',
        'scripts' => 'Reading the site scripts',
        'files' => 'Checking robots.txt and llms.txt',
        'checks' => 'Running 15 checks',
    ],
    'verdicts' => [
        'ready' => 'Ready for AI agents',
        'almost' => 'Almost ready for AI agents',
        'partly' => 'Partly ready for AI agents',
        'not_ready' => 'Not ready for AI agents',
    ],
    'groups' => [
        'B' => [
            'title' => 'Can AI find you',
            'text' => 'What AI models and search bots see',
        ],
        'A' => [
            'title' => 'What an agent can do on the site',
            'text' => 'WebMCP tools for AI agents in the browser',
        ],
        'D' => [
            'title' => 'How clear the tools are',
            'text' => 'Names, descriptions, schemas and hints',
        ],
        'C' => [
            'title' => 'Is it safe for an agent here',
            'text' => 'HTTPS, script limits, mixed content',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => 'Can an agent fill in a form?',
            'text' => 'Forms with toolname and tooldescription',
            'fix' => 'Add toolname and tooldescription to a form that performs a useful action (search, booking, order) and describe every field with toolparamdescription.',
            'notes' => [
                'none' => 'There are no forms with a toolname attribute on the page.',
                'imperative_only' => 'The site registers its tools from JavaScript, so forms are not required.',
                'no_description' => ':count form(s) have toolname but no tooldescription: an agent will not know what they do.',
                'found' => ':count form(s) are available to AI agents as tools.',
            ],
        ],
        'A2' => [
            'title' => 'Does the site give an agent actions from JavaScript?',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'Register tools from JavaScript with document.modelContext.registerTool(). navigator.modelContext is the old location of the API, deprecated since mid-2026.',
            'notes' => [
                'none' => 'No registerTool() calls were found in :scripts script(s) of the site. Code that loads only after a user action is not checked.',
                'declarative_only' => 'The site offers its tools as forms, so JavaScript registration is not required.',
                'deprecated' => ':count tool(s) found, but the code uses navigator.modelContext, the old location of the API.',
                'found' => ':count tool(s) are registered from JavaScript.',
            ],
        ],
        'A3' => [
            'title' => 'Are form fields clear to an agent?',
            'text' => 'name and toolparamdescription on every field',
            'fix' => 'Give every field of a tool form a name and a toolparamdescription; use exact types (email, number, date) and required or pattern where values follow rules.',
            'notes' => [
                'no_forms' => 'There are no tool forms on the page.',
                'no_fields' => 'The tool forms have no fields an agent could fill in.',
                'all_good' => 'All :count fields are described.',
                'some_missing' => ':good of :count fields are fully described.',
                'most_missing' => 'Only :good of :count fields are fully described.',
            ],
        ],
        'B1' => [
            'title' => 'Does AI understand what the site is?',
            'text' => 'Schema.org structured data',
            'fix' => 'Add a JSON-LD block with the Schema.org type that fits the page: Organization, LocalBusiness, Product, Article or FAQPage.',
            'notes' => [
                'json_ld' => ':count JSON-LD block(s) found.',
                'invalid_json' => 'There is JSON-LD on the page, but it is not valid JSON, so models ignore it.',
                'microdata_only' => 'Only microdata is used; JSON-LD is easier for AI models to read.',
                'none' => 'There is no structured data on the page.',
            ],
        ],
        'B2' => [
            'title' => 'Is there a short guide to the site for AI?',
            'text' => 'The /llms.txt file',
            'fix' => 'Create /llms.txt: a short Markdown summary of the site with links to its main pages (llmstxt.org).',
            'notes' => [
                'found' => 'The file is available.',
                'full_only' => 'Only /llms-full.txt was found; /llms.txt is the file models look for first.',
                'none' => 'Neither /llms.txt nor /llms-full.txt was found.',
            ],
        ],
        'B3' => [
            'title' => 'Does a meta description describe the page?',
            'text' => '50–160 characters',
            'fix' => 'Write a meta description that says what the page offers, 50–160 characters long.',
            'notes' => [
                'none' => 'The page has no meta description.',
                'good' => ':length characters, within :min–:max.',
                'length' => ':length characters; the norm is :min–:max.',
            ],
        ],
        'B4' => [
            'title' => 'Does a link to the site look good?',
            'text' => 'Open Graph tags',
            'fix' => 'Add the missing Open Graph tags: agents and social networks use them to describe a link.',
            'notes' => [
                'all' => 'All :total tags are present.',
                'none' => 'There are no Open Graph tags on the page.',
                'some' => ':count of :total tags; missing: :missing.',
            ],
        ],
        'B5' => [
            'title' => 'Does the site let AI bots in?',
            'text' => 'robots.txt rules',
            'fix' => 'Allow the AI crawlers you want to be found by in robots.txt, or remove the rules that block them.',
            'notes' => [
                'no_robots' => 'There is no robots.txt, so nothing is blocked.',
                'allowed' => 'AI crawlers are allowed.',
                'all_blocked' => 'All known AI crawlers are blocked.',
                'some_blocked' => ':count AI crawler(s) are blocked.',
            ],
        ],
        'C1' => [
            'title' => 'Is the connection secure?',
            'text' => 'HTTPS',
            'fix' => 'Move the site to HTTPS and redirect http:// to https://: WebMCP works only in a secure context.',
            'notes' => [
                'https' => 'The page is served over HTTPS.',
                'http' => 'The page is served over plain HTTP, where browsers do not offer WebMCP.',
            ],
        ],
        'C2' => [
            'title' => 'Does the page limit third-party scripts?',
            'text' => 'Content-Security-Policy header',
            'fix' => 'Send a Content-Security-Policy header: start strict and allow only the sources the site really uses.',
            'notes' => [
                'none' => 'There is no Content-Security-Policy header.',
                'unsafe_eval' => 'The policy allows \'unsafe-eval\'.',
                'found' => 'A policy is set.',
            ],
        ],
        'C3' => [
            'title' => 'Does everything load over HTTPS?',
            'text' => 'No http:// resources',
            'fix' => 'Load every script, style, image and frame over https://.',
            'notes' => [
                'not_https' => 'The page is not served over HTTPS.',
                'none' => 'All resources load over HTTPS.',
                'found' => ':count resource(s) load over plain HTTP.',
            ],
        ],
        'D1' => [
            'title' => 'Do names say what a tool does?',
            'text' => 'Names per the spec',
            'fix' => 'Use names of 3–128 characters from a–z, 0–9, "_", "-" and "." that start with an action: search_products, book_table.',
            'notes' => [
                'no_tools' => 'There are no tools to check.',
                'unreadable' => 'Tool names are built at run time and cannot be read without running the code.',
                'all_good' => 'All :count names are good.',
                'bad_names' => ':good of :count names are good.',
            ],
        ],
        'D2' => [
            'title' => 'Are the descriptions detailed enough?',
            'text' => 'At least 20 characters',
            'fix' => 'Describe in one or two sentences what each tool does and when to use it: the model picks a tool by its description.',
            'notes' => [
                'no_tools' => 'There are no tools to check.',
                'unreadable' => 'Tool descriptions are built at run time and cannot be read without running the code.',
                'all_good' => 'All :count descriptions are long enough.',
                'short' => ':good of :count descriptions are long enough.',
            ],
        ],
        'D3' => [
            'title' => 'Does the agent know which parameters to pass?',
            'text' => 'inputSchema and field descriptions',
            'fix' => 'Give every JavaScript tool an inputSchema with typed, described properties, and describe every form field with toolparamdescription.',
            'notes' => [
                'no_tools' => 'There are no tools to check.',
                'unreadable' => 'Tool schemas are built at run time and cannot be read without running the code.',
                'all_good' => 'All :count tools describe their parameters.',
                'incomplete' => ':good of :count tools describe their parameters fully.',
            ],
        ],
        'D4' => [
            'title' => 'Does the agent know which actions change data?',
            'text' => 'The readOnlyHint hint',
            'fix' => 'Add annotations to JavaScript tools, at least readOnlyHint: true for tools that only read data.',
            'notes' => [
                'no_tools' => 'There are no tools to check.',
                'declarative_only' => 'Annotations apply to JavaScript tools only.',
                'all_good' => 'All :count tools have annotations.',
                'missing' => ':good of :count tools have annotations.',
            ],
        ],
    ],
];
