<?php

return [
    'form' => [
        'label' => 'Indirizzo della pagina',
        'button' => 'Verifica',
        'hint' => 'Gratis · senza registrazione · fino a :count verifiche all’ora',
    ],
    'loading' => [
        'page' => 'Scansione della pagina',
        'scripts' => 'Lettura degli script del sito',
        'files' => 'Verifica di robots.txt e llms.txt',
        'checks' => 'Esecuzione di 15 controlli',
    ],
    'verdicts' => [
        'ready' => 'Pronto per gli agenti IA',
        'almost' => 'Quasi pronto per gli agenti IA',
        'partly' => 'Parzialmente pronto per gli agenti IA',
        'not_ready' => 'Non pronto per gli agenti IA',
    ],
    'groups' => [
        'B' => [
            'title' => 'L’IA ti trova?',
            'text' => 'Cosa vedono i modelli di IA e i bot di ricerca',
        ],
        'A' => [
            'title' => 'Cosa può fare un agente sul sito',
            'text' => 'Strumenti WebMCP per gli agenti IA nel browser',
        ],
        'D' => [
            'title' => 'Quanto sono chiari gli strumenti',
            'text' => 'Nomi, descrizioni, schemi e indicazioni',
        ],
        'C' => [
            'title' => 'È sicuro per un agente lavorare qui?',
            'text' => 'HTTPS, limiti agli script, contenuti misti',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => 'Un agente può compilare un modulo?',
            'text' => 'Moduli con toolname e tooldescription',
            'fix' => 'Aggiungi toolname e tooldescription a un modulo che svolge un’azione utile (ricerca, prenotazione, ordine) e descrivi ogni campo con toolparamdescription.',
            'notes' => [
                'none' => 'Nella pagina non ci sono moduli con l’attributo toolname.',
                'imperative_only' => 'Il sito registra i suoi strumenti con JavaScript, quindi i moduli non sono necessari.',
                'no_description' => 'Moduli con toolname ma senza tooldescription: :count. Un agente non saprà cosa fanno.',
                'found' => 'Moduli disponibili agli agenti IA come strumenti: :count.',
            ],
        ],
        'A2' => [
            'title' => 'Il sito offre all’agente azioni da JavaScript?',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'Registra gli strumenti con JavaScript tramite document.modelContext.registerTool(). navigator.modelContext è la vecchia posizione dell’API, deprecata da metà 2026.',
            'notes' => [
                'none' => 'Nessuna chiamata a registerTool() trovata negli script del sito (:scripts). Il codice caricato solo dopo un’azione dell’utente non viene verificato.',
                'declarative_only' => 'Il sito offre i suoi strumenti come moduli, quindi la registrazione con JavaScript non è necessaria.',
                'deprecated' => 'Strumenti trovati: :count, ma il codice usa navigator.modelContext, la vecchia posizione dell’API.',
                'found' => 'Strumenti registrati con JavaScript: :count.',
            ],
        ],
        'A3' => [
            'title' => 'I campi dei moduli sono chiari per un agente?',
            'text' => 'name e toolparamdescription in ogni campo',
            'fix' => 'Dai a ogni campo di un modulo-strumento un name e un toolparamdescription; usa tipi precisi (email, number, date) e required o pattern quando i valori seguono regole.',
            'notes' => [
                'no_forms' => 'Nella pagina non ci sono moduli-strumento.',
                'no_fields' => 'I moduli-strumento non hanno campi che un agente possa compilare.',
                'all_good' => 'Tutti i campi sono descritti (:count).',
                'some_missing' => ':good campi su :count sono descritti completamente.',
                'most_missing' => 'Solo :good campi su :count sono descritti completamente.',
            ],
        ],
        'B1' => [
            'title' => 'L’IA capisce che sito è?',
            'text' => 'Dati strutturati Schema.org',
            'fix' => 'Aggiungi un blocco JSON-LD con il tipo Schema.org adatto alla pagina: Organization, LocalBusiness, Product, Article o FAQPage.',
            'notes' => [
                'json_ld' => 'Blocchi JSON-LD trovati: :count.',
                'invalid_json' => 'Nella pagina c’è JSON-LD, ma non è JSON valido, quindi i modelli lo ignorano.',
                'microdata_only' => 'Sono usati solo i microdati; il JSON-LD è più facile da leggere per i modelli di IA.',
                'none' => 'Nella pagina non ci sono dati strutturati.',
            ],
        ],
        'B2' => [
            'title' => 'Esiste una breve guida al sito per l’IA?',
            'text' => 'Il file /llms.txt',
            'fix' => 'Crea /llms.txt: un breve riepilogo del sito in Markdown con i link alle pagine principali (llmstxt.org).',
            'notes' => [
                'found' => 'Il file è disponibile.',
                'full_only' => 'È stato trovato solo /llms-full.txt; i modelli cercano prima /llms.txt.',
                'none' => 'Non sono stati trovati né /llms.txt né /llms-full.txt.',
            ],
        ],
        'B3' => [
            'title' => 'Una meta description descrive la pagina?',
            'text' => '50–160 caratteri',
            'fix' => 'Scrivi una meta description che dica cosa offre la pagina, lunga 50–160 caratteri.',
            'notes' => [
                'none' => 'La pagina non ha una meta description.',
                'good' => ':length caratteri, entro :min–:max.',
                'length' => ':length caratteri; il consigliato è :min–:max.',
            ],
        ],
        'B4' => [
            'title' => 'Un link al sito ha un bell’aspetto?',
            'text' => 'Tag Open Graph',
            'fix' => 'Aggiungi i tag Open Graph mancanti: agenti e social network li usano per descrivere un link.',
            'notes' => [
                'all' => 'Ci sono tutti i :total tag.',
                'none' => 'Nella pagina non ci sono tag Open Graph.',
                'some' => ':count tag su :total; mancano: :missing.',
            ],
        ],
        'B5' => [
            'title' => 'Il sito lascia entrare i bot IA?',
            'text' => 'Regole di robots.txt',
            'fix' => 'Consenti in robots.txt i crawler IA da cui vuoi essere trovato, oppure rimuovi le regole che li bloccano.',
            'notes' => [
                'no_robots' => 'Non c’è robots.txt, quindi non è bloccato nulla.',
                'allowed' => 'I crawler IA sono consentiti.',
                'all_blocked' => 'Tutti i crawler IA noti sono bloccati.',
                'some_blocked' => 'Crawler IA bloccati: :count.',
            ],
        ],
        'C1' => [
            'title' => 'La connessione è sicura?',
            'text' => 'HTTPS',
            'fix' => 'Porta il sito su HTTPS e reindirizza http:// a https://: WebMCP funziona solo in un contesto sicuro.',
            'notes' => [
                'https' => 'La pagina è servita in HTTPS.',
                'http' => 'La pagina è servita in HTTP non cifrato, dove i browser non offrono WebMCP.',
            ],
        ],
        'C2' => [
            'title' => 'La pagina limita gli script di terze parti?',
            'text' => 'Intestazione Content-Security-Policy',
            'fix' => 'Invia un’intestazione Content-Security-Policy: parti da una politica rigida e consenti solo le fonti che il sito usa davvero.',
            'notes' => [
                'none' => 'Non c’è un’intestazione Content-Security-Policy.',
                'unsafe_eval' => 'La politica consente \'unsafe-eval\'.',
                'found' => 'È impostata una politica.',
            ],
        ],
        'C3' => [
            'title' => 'Tutto viene caricato in HTTPS?',
            'text' => 'Nessuna risorsa http://',
            'fix' => 'Carica tutti gli script, gli stili, le immagini e i frame tramite https://.',
            'notes' => [
                'not_https' => 'La pagina non è servita in HTTPS.',
                'none' => 'Tutte le risorse sono caricate in HTTPS.',
                'found' => 'Risorse caricate in HTTP non cifrato: :count.',
            ],
        ],
        'D1' => [
            'title' => 'I nomi dicono cosa fa lo strumento?',
            'text' => 'Nomi secondo la specifica',
            'fix' => 'Usa nomi di 3–128 caratteri tra a–z, 0–9, «_», «-» e «.» che inizino con un’azione: search_products, book_table.',
            'notes' => [
                'no_tools' => 'Non ci sono strumenti da verificare.',
                'unreadable' => 'I nomi degli strumenti sono costruiti in esecuzione e non si possono leggere senza eseguire il codice.',
                'all_good' => 'Tutti i nomi sono validi (:count).',
                'bad_names' => 'Nomi validi: :good su :count.',
            ],
        ],
        'D2' => [
            'title' => 'Le descrizioni sono abbastanza dettagliate?',
            'text' => 'Almeno 20 caratteri',
            'fix' => 'Descrivi in una o due frasi cosa fa ogni strumento e quando usarlo: il modello sceglie lo strumento in base alla descrizione.',
            'notes' => [
                'no_tools' => 'Non ci sono strumenti da verificare.',
                'unreadable' => 'Le descrizioni degli strumenti sono costruite in esecuzione e non si possono leggere senza eseguire il codice.',
                'all_good' => 'Tutte le descrizioni sono abbastanza lunghe (:count).',
                'short' => 'Descrizioni abbastanza lunghe: :good su :count.',
            ],
        ],
        'D3' => [
            'title' => 'L’agente sa quali parametri passare?',
            'text' => 'inputSchema e descrizioni dei campi',
            'fix' => 'Dai a ogni strumento JavaScript un inputSchema con proprietà tipizzate e descritte, e descrivi ogni campo del modulo con toolparamdescription.',
            'notes' => [
                'no_tools' => 'Non ci sono strumenti da verificare.',
                'unreadable' => 'Gli schemi degli strumenti sono costruiti in esecuzione e non si possono leggere senza eseguire il codice.',
                'all_good' => 'Tutti gli strumenti descrivono i loro parametri (:count).',
                'incomplete' => ':good strumenti su :count descrivono completamente i loro parametri.',
            ],
        ],
        'D4' => [
            'title' => 'L’agente sa quali azioni modificano i dati?',
            'text' => 'L’indicazione readOnlyHint',
            'fix' => 'Aggiungi annotazioni agli strumenti JavaScript, almeno readOnlyHint: true per quelli che leggono solo dati.',
            'notes' => [
                'no_tools' => 'Non ci sono strumenti da verificare.',
                'declarative_only' => 'Le annotazioni valgono solo per gli strumenti JavaScript.',
                'all_good' => 'Tutti gli strumenti hanno annotazioni (:count).',
                'missing' => ':good strumenti su :count hanno annotazioni.',
            ],
        ],
    ],
];
