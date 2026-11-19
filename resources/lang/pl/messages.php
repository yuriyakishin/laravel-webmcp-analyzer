<?php

declare(strict_types=1);

return [
    'form' => [
        'label' => 'Adres strony',
        'button' => 'Sprawdź',
        'hint' => 'Za darmo · bez rejestracji · do :count sprawdzeń na godzinę',
    ],
    'loading' => [
        'page' => 'Skanuję stronę',
        'scripts' => 'Czytam skrypty serwisu',
        'files' => 'Sprawdzam robots.txt i llms.txt',
        'checks' => 'Wykonuję 15 sprawdzeń',
    ],
    'verdicts' => [
        'ready' => 'Gotowy na agentów AI',
        'almost' => 'Prawie gotowy na agentów AI',
        'partly' => 'Częściowo gotowy na agentów AI',
        'not_ready' => 'Niegotowy na agentów AI',
    ],
    'groups' => [
        'B' => [
            'title' => 'Czy AI cię znajduje?',
            'text' => 'Co widzą modele AI i boty wyszukiwarek',
        ],
        'A' => [
            'title' => 'Co agent może zrobić w serwisie',
            'text' => 'Narzędzia WebMCP dla agentów AI w przeglądarce',
        ],
        'D' => [
            'title' => 'Na ile zrozumiałe są narzędzia',
            'text' => 'Nazwy, opisy, schematy i wskazówki',
        ],
        'C' => [
            'title' => 'Czy agentowi jest tu bezpiecznie?',
            'text' => 'HTTPS, ograniczenia skryptów, treści mieszane',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => 'Czy agent może wypełnić formularz?',
            'text' => 'Formularze z toolname i tooldescription',
            'fix' => 'Dodaj toolname i tooldescription do formularza, który wykonuje przydatną akcję (wyszukiwanie, rezerwacja, zamówienie), i opisz każde pole atrybutem toolparamdescription.',
            'notes' => [
                'none' => 'Na stronie nie ma formularzy z atrybutem toolname.',
                'imperative_only' => 'Serwis rejestruje narzędzia w JavaScript, więc formularze nie są potrzebne.',
                'no_description' => 'Formularze z toolname, ale bez tooldescription: :count. Agent nie będzie wiedział, co robią.',
                'found' => 'Formularze dostępne dla agentów AI jako narzędzia: :count.',
            ],
        ],
        'A2' => [
            'title' => 'Czy serwis daje agentowi akcje z JavaScript?',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'Rejestruj narzędzia w JavaScript przez document.modelContext.registerTool(). navigator.modelContext to stare miejsce API, przestarzałe od połowy 2026 roku.',
            'notes' => [
                'none' => 'W skryptach serwisu (:scripts) nie znaleziono wywołań registerTool(). Kod ładowany dopiero po akcji użytkownika nie jest sprawdzany.',
                'declarative_only' => 'Serwis udostępnia narzędzia jako formularze, więc rejestracja w JavaScript nie jest potrzebna.',
                'deprecated' => 'Znaleziono narzędzia: :count, ale kod używa navigator.modelContext, starego miejsca API.',
                'found' => 'Narzędzia zarejestrowane w JavaScript: :count.',
            ],
        ],
        'A3' => [
            'title' => 'Czy pola formularzy są zrozumiałe dla agenta?',
            'text' => 'name i toolparamdescription w każdym polu',
            'fix' => 'Nadaj każdemu polu formularza-narzędzia name i toolparamdescription; używaj dokładnych typów (email, number, date) oraz required lub pattern, gdy wartości mają reguły.',
            'notes' => [
                'no_forms' => 'Na stronie nie ma formularzy-narzędzi.',
                'no_fields' => 'Formularze-narzędzia nie mają pól, które agent mógłby wypełnić.',
                'all_good' => 'Wszystkie pola są opisane (:count).',
                'some_missing' => 'W pełni opisano :good z :count pól.',
                'most_missing' => 'W pełni opisano tylko :good z :count pól.',
            ],
        ],
        'B1' => [
            'title' => 'Czy AI rozumie, co to za serwis?',
            'text' => 'Dane strukturalne Schema.org',
            'fix' => 'Dodaj blok JSON-LD z typem Schema.org pasującym do strony: Organization, LocalBusiness, Product, Article lub FAQPage.',
            'notes' => [
                'json_ld' => 'Znalezione bloki JSON-LD: :count.',
                'invalid_json' => 'Na stronie jest JSON-LD, ale to niepoprawny JSON, więc modele go ignorują.',
                'microdata_only' => 'Używane są tylko mikrodane; JSON-LD jest łatwiejszy do odczytu dla modeli AI.',
                'none' => 'Na stronie nie ma danych strukturalnych.',
            ],
        ],
        'B2' => [
            'title' => 'Czy jest dla AI krótki przewodnik po serwisie?',
            'text' => 'Plik /llms.txt',
            'fix' => 'Utwórz /llms.txt: krótkie podsumowanie serwisu w Markdown z linkami do głównych stron (llmstxt.org).',
            'notes' => [
                'found' => 'Plik jest dostępny.',
                'full_only' => 'Znaleziono tylko /llms-full.txt; modele najpierw szukają /llms.txt.',
                'none' => 'Nie znaleziono ani /llms.txt, ani /llms-full.txt.',
            ],
        ],
        'B3' => [
            'title' => 'Czy meta description opisuje stronę?',
            'text' => '50–160 znaków',
            'fix' => 'Napisz meta description, który mówi, co oferuje strona, o długości 50–160 znaków.',
            'notes' => [
                'none' => 'Strona nie ma meta description.',
                'good' => ':length znaków, w zakresie :min–:max.',
                'length' => ':length znaków; norma to :min–:max.',
            ],
        ],
        'B4' => [
            'title' => 'Czy link do serwisu dobrze wygląda?',
            'text' => 'Tagi Open Graph',
            'fix' => 'Dodaj brakujące tagi Open Graph: agenci i sieci społecznościowe opisują nimi link.',
            'notes' => [
                'all' => 'Wszystkie :total tagi są na miejscu.',
                'none' => 'Na stronie nie ma tagów Open Graph.',
                'some' => ':count z :total tagów; brakuje: :missing.',
            ],
        ],
        'B5' => [
            'title' => 'Czy serwis wpuszcza boty AI?',
            'text' => 'Reguły robots.txt',
            'fix' => 'Zezwól w robots.txt robotom AI, przez które chcesz być znajdowany, albo usuń reguły, które je blokują.',
            'notes' => [
                'no_robots' => 'Nie ma robots.txt, więc nic nie jest zablokowane.',
                'allowed' => 'Roboty AI mają dostęp.',
                'all_blocked' => 'Wszystkie znane roboty AI są zablokowane.',
                'some_blocked' => 'Zablokowane roboty AI: :count.',
            ],
        ],
        'C1' => [
            'title' => 'Czy połączenie jest bezpieczne?',
            'text' => 'HTTPS',
            'fix' => 'Przenieś serwis na HTTPS i przekierowuj http:// na https://: WebMCP działa tylko w bezpiecznym kontekście.',
            'notes' => [
                'https' => 'Strona jest serwowana przez HTTPS.',
                'http' => 'Strona jest serwowana przez nieszyfrowany HTTP, gdzie przeglądarki nie udostępniają WebMCP.',
            ],
        ],
        'C2' => [
            'title' => 'Czy strona ogranicza skrypty z zewnątrz?',
            'text' => 'Nagłówek Content-Security-Policy',
            'fix' => 'Wysyłaj nagłówek Content-Security-Policy: zacznij od ścisłej polityki i zezwalaj tylko na źródła, których serwis naprawdę używa.',
            'notes' => [
                'none' => 'Brak nagłówka Content-Security-Policy.',
                'unsafe_eval' => 'Polityka zezwala na \'unsafe-eval\'.',
                'found' => 'Polityka jest ustawiona.',
            ],
        ],
        'C3' => [
            'title' => 'Czy wszystko ładuje się przez HTTPS?',
            'text' => 'Brak zasobów http://',
            'fix' => 'Ładuj wszystkie skrypty, style, obrazy i ramki przez https://.',
            'notes' => [
                'not_https' => 'Strona nie jest serwowana przez HTTPS.',
                'none' => 'Wszystkie zasoby ładują się przez HTTPS.',
                'found' => 'Zasoby ładowane przez nieszyfrowany HTTP: :count.',
            ],
        ],
        'D1' => [
            'title' => 'Czy nazwy mówią, co robi narzędzie?',
            'text' => 'Nazwy zgodne ze specyfikacją',
            'fix' => 'Używaj nazw z 3–128 znaków a–z, 0–9, „_”, „-” i „.”, zaczynających się od akcji: search_products, book_table.',
            'notes' => [
                'no_tools' => 'Brak narzędzi do sprawdzenia.',
                'unreadable' => 'Nazwy narzędzi powstają w trakcie działania kodu i nie da się ich odczytać bez jego uruchomienia.',
                'all_good' => 'Wszystkie nazwy są dobre (:count).',
                'bad_names' => 'Dobre nazwy: :good z :count.',
            ],
        ],
        'D2' => [
            'title' => 'Czy opisy są wystarczająco szczegółowe?',
            'text' => 'Co najmniej 20 znaków',
            'fix' => 'Opisz w jednym-dwóch zdaniach, co robi każde narzędzie i kiedy go używać: model wybiera narzędzie po opisie.',
            'notes' => [
                'no_tools' => 'Brak narzędzi do sprawdzenia.',
                'unreadable' => 'Opisy narzędzi powstają w trakcie działania kodu i nie da się ich odczytać bez jego uruchomienia.',
                'all_good' => 'Wszystkie opisy są wystarczająco długie (:count).',
                'short' => 'Wystarczająco długie opisy: :good z :count.',
            ],
        ],
        'D3' => [
            'title' => 'Czy agent wie, jakie parametry przekazać?',
            'text' => 'inputSchema i opisy pól',
            'fix' => 'Nadaj każdemu narzędziu JavaScript inputSchema z typowanymi i opisanymi właściwościami, a każde pole formularza opisz atrybutem toolparamdescription.',
            'notes' => [
                'no_tools' => 'Brak narzędzi do sprawdzenia.',
                'unreadable' => 'Schematy narzędzi powstają w trakcie działania kodu i nie da się ich odczytać bez jego uruchomienia.',
                'all_good' => 'Wszystkie narzędzia opisują swoje parametry (:count).',
                'incomplete' => 'W pełni opisuje parametry :good z :count narzędzi.',
            ],
        ],
        'D4' => [
            'title' => 'Czy agent wie, które akcje zmieniają dane?',
            'text' => 'Wskazówka readOnlyHint',
            'fix' => 'Dodaj adnotacje do narzędzi JavaScript, co najmniej readOnlyHint: true dla tych, które tylko odczytują dane.',
            'notes' => [
                'no_tools' => 'Brak narzędzi do sprawdzenia.',
                'declarative_only' => 'Adnotacje dotyczą tylko narzędzi JavaScript.',
                'all_good' => 'Wszystkie narzędzia mają adnotacje (:count).',
                'missing' => 'Adnotacje ma :good z :count narzędzi.',
            ],
        ],
    ],
];
