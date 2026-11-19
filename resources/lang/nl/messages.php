<?php

declare(strict_types=1);

return [
    'form' => [
        'label' => 'Paginaadres',
        'button' => 'Controleren',
        'hint' => 'Gratis · zonder registratie · tot :count controles per uur',
    ],
    'loading' => [
        'page' => 'Pagina scannen',
        'scripts' => 'Scripts van de site lezen',
        'files' => 'robots.txt en llms.txt controleren',
        'checks' => '15 controles uitvoeren',
    ],
    'verdicts' => [
        'ready' => 'Klaar voor AI-agents',
        'almost' => 'Bijna klaar voor AI-agents',
        'partly' => 'Gedeeltelijk klaar voor AI-agents',
        'not_ready' => 'Niet klaar voor AI-agents',
    ],
    'groups' => [
        'B' => [
            'title' => 'Vindt AI u?',
            'text' => 'Wat AI-modellen en zoekbots zien',
        ],
        'A' => [
            'title' => 'Wat een agent op de site kan doen',
            'text' => 'WebMCP-tools voor AI-agents in de browser',
        ],
        'D' => [
            'title' => 'Hoe duidelijk de tools zijn',
            'text' => 'Namen, beschrijvingen, schema’s en hints',
        ],
        'C' => [
            'title' => 'Is het hier veilig voor een agent?',
            'text' => 'HTTPS, scriptbeperkingen, gemengde inhoud',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => 'Kan een agent een formulier invullen?',
            'text' => 'Formulieren met toolname en tooldescription',
            'fix' => 'Voeg toolname en tooldescription toe aan een formulier dat een nuttige actie uitvoert (zoeken, boeken, bestellen) en beschrijf elk veld met toolparamdescription.',
            'notes' => [
                'none' => 'Op de pagina staan geen formulieren met het attribuut toolname.',
                'imperative_only' => 'De site registreert zijn tools met JavaScript, dus formulieren zijn niet nodig.',
                'no_description' => 'Formulieren met toolname maar zonder tooldescription: :count. Een agent weet niet wat ze doen.',
                'found' => 'Formulieren die als tools beschikbaar zijn voor AI-agents: :count.',
            ],
        ],
        'A2' => [
            'title' => 'Geeft de site een agent acties via JavaScript?',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'Registreer tools met JavaScript via document.modelContext.registerTool(). navigator.modelContext is de oude plek van de API, verouderd sinds medio 2026.',
            'notes' => [
                'none' => 'Geen registerTool()-aanroepen gevonden in de scripts van de site (:scripts). Code die pas na een actie van de gebruiker laadt, wordt niet gecontroleerd.',
                'declarative_only' => 'De site biedt zijn tools aan als formulieren, dus registratie met JavaScript is niet nodig.',
                'deprecated' => 'Gevonden tools: :count, maar de code gebruikt navigator.modelContext, de oude plek van de API.',
                'found' => 'Met JavaScript geregistreerde tools: :count.',
            ],
        ],
        'A3' => [
            'title' => 'Zijn de formuliervelden duidelijk voor een agent?',
            'text' => 'name en toolparamdescription bij elk veld',
            'fix' => 'Geef elk veld van een toolformulier een name en een toolparamdescription; gebruik precieze types (email, number, date) en required of pattern als waarden regels volgen.',
            'notes' => [
                'no_forms' => 'Op de pagina staan geen toolformulieren.',
                'no_fields' => 'De toolformulieren hebben geen velden die een agent kan invullen.',
                'all_good' => 'Alle velden zijn beschreven (:count).',
                'some_missing' => ':good van :count velden zijn volledig beschreven.',
                'most_missing' => 'Slechts :good van :count velden zijn volledig beschreven.',
            ],
        ],
        'B1' => [
            'title' => 'Begrijpt AI wat voor site dit is?',
            'text' => 'Gestructureerde gegevens Schema.org',
            'fix' => 'Voeg een JSON-LD-blok toe met het Schema.org-type dat bij de pagina past: Organization, LocalBusiness, Product, Article of FAQPage.',
            'notes' => [
                'json_ld' => 'Gevonden JSON-LD-blokken: :count.',
                'invalid_json' => 'Er staat JSON-LD op de pagina, maar het is geen geldige JSON, dus modellen negeren het.',
                'microdata_only' => 'Er wordt alleen microdata gebruikt; JSON-LD is makkelijker te lezen voor AI-modellen.',
                'none' => 'Op de pagina staan geen gestructureerde gegevens.',
            ],
        ],
        'B2' => [
            'title' => 'Is er een korte gids van de site voor AI?',
            'text' => 'Het bestand /llms.txt',
            'fix' => 'Maak /llms.txt: een korte samenvatting van de site in Markdown met links naar de belangrijkste pagina’s (llmstxt.org).',
            'notes' => [
                'found' => 'Het bestand is beschikbaar.',
                'full_only' => 'Alleen /llms-full.txt is gevonden; modellen zoeken eerst naar /llms.txt.',
                'none' => 'Noch /llms.txt noch /llms-full.txt is gevonden.',
            ],
        ],
        'B3' => [
            'title' => 'Beschrijft een meta description de pagina?',
            'text' => '50–160 tekens',
            'fix' => 'Schrijf een meta description die zegt wat de pagina biedt, 50–160 tekens lang.',
            'notes' => [
                'none' => 'De pagina heeft geen meta description.',
                'good' => ':length tekens, binnen :min–:max.',
                'length' => ':length tekens; aanbevolen is :min–:max.',
            ],
        ],
        'B4' => [
            'title' => 'Ziet een link naar de site er goed uit?',
            'text' => 'Open Graph-tags',
            'fix' => 'Voeg de ontbrekende Open Graph-tags toe: agents en sociale netwerken beschrijven er een link mee.',
            'notes' => [
                'all' => 'Alle :total tags zijn aanwezig.',
                'none' => 'Op de pagina staan geen Open Graph-tags.',
                'some' => ':count van :total tags; ontbrekend: :missing.',
            ],
        ],
        'B5' => [
            'title' => 'Laat de site AI-bots binnen?',
            'text' => 'Regels in robots.txt',
            'fix' => 'Sta in robots.txt de AI-crawlers toe waarmee u gevonden wilt worden, of verwijder de regels die ze blokkeren.',
            'notes' => [
                'no_robots' => 'Er is geen robots.txt, dus er is niets geblokkeerd.',
                'allowed' => 'AI-crawlers zijn toegestaan.',
                'all_blocked' => 'Alle bekende AI-crawlers zijn geblokkeerd.',
                'some_blocked' => 'Geblokkeerde AI-crawlers: :count.',
            ],
        ],
        'C1' => [
            'title' => 'Is de verbinding veilig?',
            'text' => 'HTTPS',
            'fix' => 'Zet de site over op HTTPS en stuur http:// door naar https://: WebMCP werkt alleen in een veilige context.',
            'notes' => [
                'https' => 'De pagina wordt via HTTPS geleverd.',
                'http' => 'De pagina wordt via onversleuteld HTTP geleverd, waar browsers geen WebMCP aanbieden.',
            ],
        ],
        'C2' => [
            'title' => 'Beperkt de pagina scripts van derden?',
            'text' => 'Header Content-Security-Policy',
            'fix' => 'Stuur een Content-Security-Policy-header: begin streng en sta alleen de bronnen toe die de site echt gebruikt.',
            'notes' => [
                'none' => 'Er is geen Content-Security-Policy-header.',
                'unsafe_eval' => 'Het beleid staat \'unsafe-eval\' toe.',
                'found' => 'Er is een beleid ingesteld.',
            ],
        ],
        'C3' => [
            'title' => 'Laadt alles via HTTPS?',
            'text' => 'Geen http://-bronnen',
            'fix' => 'Laad alle scripts, stijlen, afbeeldingen en frames via https://.',
            'notes' => [
                'not_https' => 'De pagina wordt niet via HTTPS geleverd.',
                'none' => 'Alle bronnen laden via HTTPS.',
                'found' => 'Bronnen via onversleuteld HTTP: :count.',
            ],
        ],
        'D1' => [
            'title' => 'Zeggen de namen wat een tool doet?',
            'text' => 'Namen volgens de specificatie',
            'fix' => 'Gebruik namen van 3–128 tekens uit a–z, 0–9, "_", "-" en "." die met een actie beginnen: search_products, book_table.',
            'notes' => [
                'no_tools' => 'Er zijn geen tools om te controleren.',
                'unreadable' => 'Toolnamen worden tijdens het uitvoeren opgebouwd en zijn niet te lezen zonder de code uit te voeren.',
                'all_good' => 'Alle namen zijn goed (:count).',
                'bad_names' => 'Goede namen: :good van :count.',
            ],
        ],
        'D2' => [
            'title' => 'Zijn de beschrijvingen uitgebreid genoeg?',
            'text' => 'Minstens 20 tekens',
            'fix' => 'Beschrijf in één of twee zinnen wat elke tool doet en wanneer je hem gebruikt: het model kiest een tool op basis van de beschrijving.',
            'notes' => [
                'no_tools' => 'Er zijn geen tools om te controleren.',
                'unreadable' => 'Toolbeschrijvingen worden tijdens het uitvoeren opgebouwd en zijn niet te lezen zonder de code uit te voeren.',
                'all_good' => 'Alle beschrijvingen zijn lang genoeg (:count).',
                'short' => 'Lang genoeg: :good van :count beschrijvingen.',
            ],
        ],
        'D3' => [
            'title' => 'Weet de agent welke parameters hij moet doorgeven?',
            'text' => 'inputSchema en veldbeschrijvingen',
            'fix' => 'Geef elke JavaScript-tool een inputSchema met getypeerde, beschreven eigenschappen en beschrijf elk formulierveld met toolparamdescription.',
            'notes' => [
                'no_tools' => 'Er zijn geen tools om te controleren.',
                'unreadable' => 'Toolschema’s worden tijdens het uitvoeren opgebouwd en zijn niet te lezen zonder de code uit te voeren.',
                'all_good' => 'Alle tools beschrijven hun parameters (:count).',
                'incomplete' => ':good van :count tools beschrijven hun parameters volledig.',
            ],
        ],
        'D4' => [
            'title' => 'Weet de agent welke acties gegevens wijzigen?',
            'text' => 'De hint readOnlyHint',
            'fix' => 'Voeg annotaties toe aan JavaScript-tools, minstens readOnlyHint: true voor tools die alleen gegevens lezen.',
            'notes' => [
                'no_tools' => 'Er zijn geen tools om te controleren.',
                'declarative_only' => 'Annotaties gelden alleen voor JavaScript-tools.',
                'all_good' => 'Alle tools hebben annotaties (:count).',
                'missing' => ':good van :count tools hebben annotaties.',
            ],
        ],
    ],
];
