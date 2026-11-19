<?php

declare(strict_types=1);

return [
    'form' => [
        'label' => 'Seitenadresse',
        'button' => 'Prüfen',
        'hint' => 'Kostenlos · ohne Registrierung · bis zu :count Prüfungen pro Stunde',
    ],
    'loading' => [
        'page' => 'Seite wird gescannt',
        'scripts' => 'Skripte der Website werden gelesen',
        'files' => 'robots.txt und llms.txt werden geprüft',
        'checks' => '15 Prüfungen laufen',
    ],
    'verdicts' => [
        'ready' => 'Bereit für KI-Agenten',
        'almost' => 'Fast bereit für KI-Agenten',
        'partly' => 'Teilweise bereit für KI-Agenten',
        'not_ready' => 'Nicht bereit für KI-Agenten',
    ],
    'groups' => [
        'B' => [
            'title' => 'Findet KI Sie?',
            'text' => 'Was KI-Modelle und Such-Bots sehen',
        ],
        'A' => [
            'title' => 'Was ein Agent auf der Website tun kann',
            'text' => 'WebMCP-Tools für KI-Agenten im Browser',
        ],
        'D' => [
            'title' => 'Wie verständlich die Tools sind',
            'text' => 'Namen, Beschreibungen, Schemas und Hinweise',
        ],
        'C' => [
            'title' => 'Ist es für einen Agenten hier sicher?',
            'text' => 'HTTPS, Skriptgrenzen, gemischte Inhalte',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => 'Kann ein Agent ein Formular ausfüllen?',
            'text' => 'Formulare mit toolname und tooldescription',
            'fix' => 'Fügen Sie toolname und tooldescription zu einem Formular hinzu, das eine nützliche Aktion ausführt (Suche, Buchung, Bestellung), und beschreiben Sie jedes Feld mit toolparamdescription.',
            'notes' => [
                'none' => 'Auf der Seite gibt es keine Formulare mit dem Attribut toolname.',
                'imperative_only' => 'Die Website registriert ihre Tools per JavaScript, Formulare sind daher nicht nötig.',
                'no_description' => 'Formulare mit toolname, aber ohne tooldescription: :count. Ein Agent weiß nicht, was sie tun.',
                'found' => 'Formulare, die KI-Agenten als Tools zur Verfügung stehen: :count.',
            ],
        ],
        'A2' => [
            'title' => 'Gibt die Website einem Agenten Aktionen per JavaScript?',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'Registrieren Sie Tools per JavaScript mit document.modelContext.registerTool(). navigator.modelContext ist der alte Ort der API und seit Mitte 2026 veraltet.',
            'notes' => [
                'none' => 'In den Skripten der Website (:scripts) wurden keine registerTool()-Aufrufe gefunden. Code, der erst nach einer Nutzeraktion lädt, wird nicht geprüft.',
                'declarative_only' => 'Die Website bietet ihre Tools als Formulare an, eine Registrierung per JavaScript ist nicht nötig.',
                'deprecated' => 'Gefundene Tools: :count, aber der Code nutzt navigator.modelContext, den alten Ort der API.',
                'found' => 'Per JavaScript registrierte Tools: :count.',
            ],
        ],
        'A3' => [
            'title' => 'Sind die Formularfelder für einen Agenten verständlich?',
            'text' => 'name und toolparamdescription an jedem Feld',
            'fix' => 'Geben Sie jedem Feld eines Tool-Formulars ein name und eine toolparamdescription; nutzen Sie genaue Typen (email, number, date) und required oder pattern, wenn Werte Regeln folgen.',
            'notes' => [
                'no_forms' => 'Auf der Seite gibt es keine Tool-Formulare.',
                'no_fields' => 'Die Tool-Formulare haben keine Felder, die ein Agent ausfüllen könnte.',
                'all_good' => 'Alle Felder sind beschrieben (:count).',
                'some_missing' => ':good von :count Feldern sind vollständig beschrieben.',
                'most_missing' => 'Nur :good von :count Feldern sind vollständig beschrieben.',
            ],
        ],
        'B1' => [
            'title' => 'Versteht KI, was das für eine Website ist?',
            'text' => 'Strukturierte Daten Schema.org',
            'fix' => 'Fügen Sie einen JSON-LD-Block mit dem passenden Schema.org-Typ hinzu: Organization, LocalBusiness, Product, Article oder FAQPage.',
            'notes' => [
                'json_ld' => 'Gefundene JSON-LD-Blöcke: :count.',
                'invalid_json' => 'Auf der Seite gibt es JSON-LD, aber kein gültiges JSON, daher ignorieren Modelle es.',
                'microdata_only' => 'Es wird nur Microdata verwendet; JSON-LD ist für KI-Modelle leichter zu lesen.',
                'none' => 'Auf der Seite gibt es keine strukturierten Daten.',
            ],
        ],
        'B2' => [
            'title' => 'Gibt es für KI einen kurzen Leitfaden zur Website?',
            'text' => 'Die Datei /llms.txt',
            'fix' => 'Erstellen Sie /llms.txt: eine kurze Markdown-Zusammenfassung der Website mit Links zu den Hauptseiten (llmstxt.org).',
            'notes' => [
                'found' => 'Die Datei ist verfügbar.',
                'full_only' => 'Nur /llms-full.txt wurde gefunden; Modelle suchen zuerst nach /llms.txt.',
                'none' => 'Weder /llms.txt noch /llms-full.txt wurde gefunden.',
            ],
        ],
        'B3' => [
            'title' => 'Beschreibt eine Meta-Description die Seite?',
            'text' => '50–160 Zeichen',
            'fix' => 'Schreiben Sie eine Meta-Description, die sagt, was die Seite bietet, 50–160 Zeichen lang.',
            'notes' => [
                'none' => 'Die Seite hat keine Meta-Description.',
                'good' => ':length Zeichen, innerhalb von :min–:max.',
                'length' => ':length Zeichen; empfohlen sind :min–:max.',
            ],
        ],
        'B4' => [
            'title' => 'Sieht ein Link zur Website gut aus?',
            'text' => 'Open-Graph-Tags',
            'fix' => 'Fügen Sie die fehlenden Open-Graph-Tags hinzu: Agenten und soziale Netzwerke beschreiben damit einen Link.',
            'notes' => [
                'all' => 'Alle :total Tags sind vorhanden.',
                'none' => 'Auf der Seite gibt es keine Open-Graph-Tags.',
                'some' => ':count von :total Tags; es fehlen: :missing.',
            ],
        ],
        'B5' => [
            'title' => 'Lässt die Website KI-Bots herein?',
            'text' => 'Regeln in robots.txt',
            'fix' => 'Erlauben Sie in robots.txt die KI-Crawler, von denen Sie gefunden werden möchten, oder entfernen Sie die Regeln, die sie sperren.',
            'notes' => [
                'no_robots' => 'Es gibt keine robots.txt, also ist nichts gesperrt.',
                'allowed' => 'KI-Crawler sind erlaubt.',
                'all_blocked' => 'Alle bekannten KI-Crawler sind gesperrt.',
                'some_blocked' => 'Gesperrte KI-Crawler: :count.',
            ],
        ],
        'C1' => [
            'title' => 'Ist die Verbindung sicher?',
            'text' => 'HTTPS',
            'fix' => 'Stellen Sie die Website auf HTTPS um und leiten Sie http:// auf https:// weiter: WebMCP funktioniert nur in einem sicheren Kontext.',
            'notes' => [
                'https' => 'Die Seite wird über HTTPS ausgeliefert.',
                'http' => 'Die Seite wird über unverschlüsseltes HTTP ausgeliefert, wo Browser WebMCP nicht anbieten.',
            ],
        ],
        'C2' => [
            'title' => 'Begrenzt die Seite fremde Skripte?',
            'text' => 'Header Content-Security-Policy',
            'fix' => 'Senden Sie einen Content-Security-Policy-Header: beginnen Sie streng und erlauben Sie nur die Quellen, die die Website wirklich nutzt.',
            'notes' => [
                'none' => 'Es gibt keinen Content-Security-Policy-Header.',
                'unsafe_eval' => 'Die Richtlinie erlaubt \'unsafe-eval\'.',
                'found' => 'Eine Richtlinie ist gesetzt.',
            ],
        ],
        'C3' => [
            'title' => 'Wird alles über HTTPS geladen?',
            'text' => 'Keine http://-Ressourcen',
            'fix' => 'Laden Sie alle Skripte, Stile, Bilder und Frames über https://.',
            'notes' => [
                'not_https' => 'Die Seite wird nicht über HTTPS ausgeliefert.',
                'none' => 'Alle Ressourcen werden über HTTPS geladen.',
                'found' => 'Ressourcen über unverschlüsseltes HTTP: :count.',
            ],
        ],
        'D1' => [
            'title' => 'Sagen die Namen, was ein Tool tut?',
            'text' => 'Namen nach Spezifikation',
            'fix' => 'Verwenden Sie Namen aus 3–128 Zeichen a–z, 0–9, „_“, „-“ und „.“, die mit einer Aktion beginnen: search_products, book_table.',
            'notes' => [
                'no_tools' => 'Es gibt keine Tools zu prüfen.',
                'unreadable' => 'Die Tool-Namen entstehen zur Laufzeit und lassen sich ohne Ausführen des Codes nicht lesen.',
                'all_good' => 'Alle Namen sind gut (:count).',
                'bad_names' => 'Gute Namen: :good von :count.',
            ],
        ],
        'D2' => [
            'title' => 'Sind die Beschreibungen ausführlich genug?',
            'text' => 'Mindestens 20 Zeichen',
            'fix' => 'Beschreiben Sie in ein bis zwei Sätzen, was jedes Tool tut und wann es zu nutzen ist: Das Modell wählt ein Tool anhand seiner Beschreibung.',
            'notes' => [
                'no_tools' => 'Es gibt keine Tools zu prüfen.',
                'unreadable' => 'Die Tool-Beschreibungen entstehen zur Laufzeit und lassen sich ohne Ausführen des Codes nicht lesen.',
                'all_good' => 'Alle Beschreibungen sind lang genug (:count).',
                'short' => 'Ausreichend lange Beschreibungen: :good von :count.',
            ],
        ],
        'D3' => [
            'title' => 'Weiß der Agent, welche Parameter er übergeben soll?',
            'text' => 'inputSchema und Feldbeschreibungen',
            'fix' => 'Geben Sie jedem JavaScript-Tool ein inputSchema mit typisierten, beschriebenen Eigenschaften und beschreiben Sie jedes Formularfeld mit toolparamdescription.',
            'notes' => [
                'no_tools' => 'Es gibt keine Tools zu prüfen.',
                'unreadable' => 'Die Tool-Schemas entstehen zur Laufzeit und lassen sich ohne Ausführen des Codes nicht lesen.',
                'all_good' => 'Alle Tools beschreiben ihre Parameter (:count).',
                'incomplete' => ':good von :count Tools beschreiben ihre Parameter vollständig.',
            ],
        ],
        'D4' => [
            'title' => 'Weiß der Agent, welche Aktionen Daten ändern?',
            'text' => 'Der Hinweis readOnlyHint',
            'fix' => 'Fügen Sie JavaScript-Tools Annotationen hinzu, mindestens readOnlyHint: true für Tools, die nur Daten lesen.',
            'notes' => [
                'no_tools' => 'Es gibt keine Tools zu prüfen.',
                'declarative_only' => 'Annotationen gelten nur für JavaScript-Tools.',
                'all_good' => 'Alle Tools haben Annotationen (:count).',
                'missing' => 'Annotationen haben :good von :count Tools.',
            ],
        ],
    ],
];
