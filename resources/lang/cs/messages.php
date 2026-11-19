<?php

declare(strict_types=1);

return [
    'form' => [
        'label' => 'Adresa stránky',
        'button' => 'Zkontrolovat',
        'hint' => 'Zdarma · bez registrace · až :count kontrol za hodinu',
    ],
    'loading' => [
        'page' => 'Skenuji stránku',
        'scripts' => 'Čtu skripty webu',
        'files' => 'Kontroluji robots.txt a llms.txt',
        'checks' => 'Provádím 15 kontrol',
    ],
    'verdicts' => [
        'ready' => 'Připraven pro AI agenty',
        'almost' => 'Téměř připraven pro AI agenty',
        'partly' => 'Částečně připraven pro AI agenty',
        'not_ready' => 'Nepřipraven pro AI agenty',
    ],
    'groups' => [
        'B' => [
            'title' => 'Najde vás AI?',
            'text' => 'Co vidí AI modely a vyhledávací roboti',
        ],
        'A' => [
            'title' => 'Co může agent na webu udělat',
            'text' => 'Nástroje WebMCP pro AI agenty v prohlížeči',
        ],
        'D' => [
            'title' => 'Jak srozumitelné jsou nástroje',
            'text' => 'Názvy, popisy, schémata a nápovědy',
        ],
        'C' => [
            'title' => 'Je tu pro agenta bezpečno?',
            'text' => 'HTTPS, omezení skriptů, smíšený obsah',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => 'Může agent vyplnit formulář?',
            'text' => 'Formuláře s toolname a tooldescription',
            'fix' => 'Přidejte toolname a tooldescription k formuláři, který provádí užitečnou akci (vyhledávání, rezervace, objednávka), a každé pole popište atributem toolparamdescription.',
            'notes' => [
                'none' => 'Na stránce nejsou formuláře s atributem toolname.',
                'imperative_only' => 'Web registruje nástroje v JavaScriptu, formuláře proto nejsou potřeba.',
                'no_description' => 'Formuláře s toolname, ale bez tooldescription: :count. Agent nebude vědět, co dělají.',
                'found' => 'Formuláře dostupné AI agentům jako nástroje: :count.',
            ],
        ],
        'A2' => [
            'title' => 'Dává web agentovi akce z JavaScriptu?',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'Registrujte nástroje v JavaScriptu přes document.modelContext.registerTool(). navigator.modelContext je staré umístění API, zastaralé od poloviny roku 2026.',
            'notes' => [
                'none' => 'Ve skriptech webu (:scripts) nebyla nalezena volání registerTool(). Kód načítaný až po akci uživatele se nekontroluje.',
                'declarative_only' => 'Web nabízí nástroje jako formuláře, registrace v JavaScriptu proto není potřeba.',
                'deprecated' => 'Nalezené nástroje: :count, ale kód používá navigator.modelContext, staré umístění API.',
                'found' => 'Nástroje registrované v JavaScriptu: :count.',
            ],
        ],
        'A3' => [
            'title' => 'Jsou pole formulářů pro agenta srozumitelná?',
            'text' => 'name a toolparamdescription u každého pole',
            'fix' => 'Dejte každému poli formuláře-nástroje name a toolparamdescription; používejte přesné typy (email, number, date) a required nebo pattern tam, kde hodnoty mají pravidla.',
            'notes' => [
                'no_forms' => 'Na stránce nejsou formuláře-nástroje.',
                'no_fields' => 'Formuláře-nástroje nemají pole, která by agent mohl vyplnit.',
                'all_good' => 'Všechna pole jsou popsaná (:count).',
                'some_missing' => 'Plně popsaných polí: :good z :count.',
                'most_missing' => 'Plně popsaných polí je jen :good z :count.',
            ],
        ],
        'B1' => [
            'title' => 'Rozumí AI, o jaký web jde?',
            'text' => 'Strukturovaná data Schema.org',
            'fix' => 'Přidejte blok JSON-LD s typem Schema.org, který odpovídá stránce: Organization, LocalBusiness, Product, Article nebo FAQPage.',
            'notes' => [
                'json_ld' => 'Nalezené bloky JSON-LD: :count.',
                'invalid_json' => 'Na stránce je JSON-LD, ale není to platný JSON, takže ho modely ignorují.',
                'microdata_only' => 'Používají se jen mikrodata; JSON-LD se AI modelům čte snáz.',
                'none' => 'Na stránce nejsou strukturovaná data.',
            ],
        ],
        'B2' => [
            'title' => 'Má AI krátkého průvodce po webu?',
            'text' => 'Soubor /llms.txt',
            'fix' => 'Vytvořte /llms.txt: krátký popis webu v Markdownu s odkazy na hlavní stránky (llmstxt.org).',
            'notes' => [
                'found' => 'Soubor je dostupný.',
                'full_only' => 'Nalezen byl jen /llms-full.txt; modely nejdřív hledají /llms.txt.',
                'none' => 'Nebyl nalezen /llms.txt ani /llms-full.txt.',
            ],
        ],
        'B3' => [
            'title' => 'Popisuje stránku meta description?',
            'text' => '50–160 znaků',
            'fix' => 'Napište meta description, který říká, co stránka nabízí, o délce 50–160 znaků.',
            'notes' => [
                'none' => 'Stránka nemá meta description.',
                'good' => ':length znaků, v rozmezí :min–:max.',
                'length' => ':length znaků; doporučeno :min–:max.',
            ],
        ],
        'B4' => [
            'title' => 'Vypadá odkaz na web dobře?',
            'text' => 'Značky Open Graph',
            'fix' => 'Přidejte chybějící značky Open Graph: agenti a sociální sítě jimi popisují odkaz.',
            'notes' => [
                'all' => 'Všech :total značek je na místě.',
                'none' => 'Na stránce nejsou značky Open Graph.',
                'some' => ':count z :total značek; chybí: :missing.',
            ],
        ],
        'B5' => [
            'title' => 'Pouští web AI roboty?',
            'text' => 'Pravidla robots.txt',
            'fix' => 'Povolte v robots.txt AI roboty, přes které chcete být nalezeni, nebo odstraňte pravidla, která je blokují.',
            'notes' => [
                'no_robots' => 'robots.txt neexistuje, nic tedy není blokováno.',
                'allowed' => 'AI roboti mají přístup povolen.',
                'all_blocked' => 'Všichni známí AI roboti jsou blokováni.',
                'some_blocked' => 'Blokovaní AI roboti: :count.',
            ],
        ],
        'C1' => [
            'title' => 'Je spojení zabezpečené?',
            'text' => 'HTTPS',
            'fix' => 'Převeďte web na HTTPS a přesměrujte http:// na https://: WebMCP funguje jen v zabezpečeném kontextu.',
            'notes' => [
                'https' => 'Stránka se načítá přes HTTPS.',
                'http' => 'Stránka se načítá přes nešifrované HTTP, kde prohlížeče WebMCP nenabízejí.',
            ],
        ],
        'C2' => [
            'title' => 'Omezuje stránka skripty třetích stran?',
            'text' => 'Hlavička Content-Security-Policy',
            'fix' => 'Posílejte hlavičku Content-Security-Policy: začněte přísně a povolte jen zdroje, které web opravdu používá.',
            'notes' => [
                'none' => 'Hlavička Content-Security-Policy chybí.',
                'unsafe_eval' => 'Politika povoluje \'unsafe-eval\'.',
                'found' => 'Politika je nastavena.',
            ],
        ],
        'C3' => [
            'title' => 'Načítá se vše přes HTTPS?',
            'text' => 'Žádné zdroje http://',
            'fix' => 'Načítejte všechny skripty, styly, obrázky a rámce přes https://.',
            'notes' => [
                'not_https' => 'Stránka se nenačítá přes HTTPS.',
                'none' => 'Všechny zdroje se načítají přes HTTPS.',
                'found' => 'Zdroje načítané přes nešifrované HTTP: :count.',
            ],
        ],
        'D1' => [
            'title' => 'Říkají názvy, co nástroj dělá?',
            'text' => 'Názvy podle specifikace',
            'fix' => 'Používejte názvy o 3–128 znacích a–z, 0–9, „_“, „-“ a „.“, které začínají akcí: search_products, book_table.',
            'notes' => [
                'no_tools' => 'Nejsou žádné nástroje ke kontrole.',
                'unreadable' => 'Názvy nástrojů vznikají za běhu kódu a nelze je přečíst bez jeho spuštění.',
                'all_good' => 'Všechny názvy jsou dobré (:count).',
                'bad_names' => 'Dobré názvy: :good z :count.',
            ],
        ],
        'D2' => [
            'title' => 'Jsou popisy dost podrobné?',
            'text' => 'Alespoň 20 znaků',
            'fix' => 'Popište jednou až dvěma větami, co každý nástroj dělá a kdy ho použít: model vybírá nástroj podle popisu.',
            'notes' => [
                'no_tools' => 'Nejsou žádné nástroje ke kontrole.',
                'unreadable' => 'Popisy nástrojů vznikají za běhu kódu a nelze je přečíst bez jeho spuštění.',
                'all_good' => 'Všechny popisy jsou dost dlouhé (:count).',
                'short' => 'Dost dlouhé popisy: :good z :count.',
            ],
        ],
        'D3' => [
            'title' => 'Ví agent, jaké parametry předat?',
            'text' => 'inputSchema a popisy polí',
            'fix' => 'Dejte každému JavaScript nástroji inputSchema s typovanými a popsanými vlastnostmi a každé pole formuláře popište atributem toolparamdescription.',
            'notes' => [
                'no_tools' => 'Nejsou žádné nástroje ke kontrole.',
                'unreadable' => 'Schémata nástrojů vznikají za běhu kódu a nelze je přečíst bez jeho spuštění.',
                'all_good' => 'Všechny nástroje popisují své parametry (:count).',
                'incomplete' => 'Parametry plně popisuje :good z :count nástrojů.',
            ],
        ],
        'D4' => [
            'title' => 'Ví agent, které akce mění data?',
            'text' => 'Nápověda readOnlyHint',
            'fix' => 'Přidejte anotace k JavaScript nástrojům, alespoň readOnlyHint: true u těch, které data jen čtou.',
            'notes' => [
                'no_tools' => 'Nejsou žádné nástroje ke kontrole.',
                'declarative_only' => 'Anotace se týkají jen JavaScript nástrojů.',
                'all_good' => 'Všechny nástroje mají anotace (:count).',
                'missing' => 'Anotace má :good z :count nástrojů.',
            ],
        ],
    ],
];
