<?php

return [
    'form' => [
        'label' => 'Adresse de la page',
        'button' => 'Vérifier',
        'hint' => 'Gratuit · sans inscription · jusqu’à :count vérifications par heure',
    ],
    'loading' => [
        'page' => 'Analyse de la page',
        'scripts' => 'Lecture des scripts du site',
        'files' => 'Vérification de robots.txt et llms.txt',
        'checks' => 'Exécution de 15 vérifications',
    ],
    'verdicts' => [
        'ready' => 'Prêt pour les agents IA',
        'almost' => 'Presque prêt pour les agents IA',
        'partly' => 'Partiellement prêt pour les agents IA',
        'not_ready' => 'Pas prêt pour les agents IA',
    ],
    'groups' => [
        'B' => [
            'title' => 'L’IA vous trouve-t-elle ?',
            'text' => 'Ce que voient les modèles d’IA et les robots de recherche',
        ],
        'A' => [
            'title' => 'Ce qu’un agent peut faire sur le site',
            'text' => 'Outils WebMCP pour les agents IA dans le navigateur',
        ],
        'D' => [
            'title' => 'Les outils sont-ils clairs ?',
            'text' => 'Noms, descriptions, schémas et indications',
        ],
        'C' => [
            'title' => 'Un agent est-il en sécurité ici ?',
            'text' => 'HTTPS, limites des scripts, contenu mixte',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => 'Un agent peut-il remplir un formulaire ?',
            'text' => 'Formulaires avec toolname et tooldescription',
            'fix' => 'Ajoutez toolname et tooldescription à un formulaire qui réalise une action utile (recherche, réservation, commande) et décrivez chaque champ avec toolparamdescription.',
            'notes' => [
                'none' => 'La page ne contient aucun formulaire avec l’attribut toolname.',
                'imperative_only' => 'Le site enregistre ses outils en JavaScript, les formulaires ne sont donc pas nécessaires.',
                'no_description' => 'Formulaires avec toolname mais sans tooldescription : :count. Un agent ne saura pas ce qu’ils font.',
                'found' => 'Formulaires disponibles comme outils pour les agents IA : :count.',
            ],
        ],
        'A2' => [
            'title' => 'Le site donne-t-il des actions à l’agent en JavaScript ?',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'Enregistrez les outils en JavaScript avec document.modelContext.registerTool(). navigator.modelContext est l’ancien emplacement de l’API, obsolète depuis mi-2026.',
            'notes' => [
                'none' => 'Aucun appel à registerTool() trouvé dans les scripts du site (:scripts). Le code chargé seulement après une action de l’utilisateur n’est pas vérifié.',
                'declarative_only' => 'Le site propose ses outils sous forme de formulaires, l’enregistrement en JavaScript n’est pas nécessaire.',
                'deprecated' => 'Outils trouvés : :count, mais le code utilise navigator.modelContext, l’ancien emplacement de l’API.',
                'found' => 'Outils enregistrés en JavaScript : :count.',
            ],
        ],
        'A3' => [
            'title' => 'Les champs des formulaires sont-ils clairs pour un agent ?',
            'text' => 'name et toolparamdescription sur chaque champ',
            'fix' => 'Donnez à chaque champ d’un formulaire-outil un name et un toolparamdescription ; utilisez des types précis (email, number, date) et required ou pattern quand les valeurs suivent des règles.',
            'notes' => [
                'no_forms' => 'La page ne contient aucun formulaire-outil.',
                'no_fields' => 'Les formulaires-outils n’ont aucun champ qu’un agent pourrait remplir.',
                'all_good' => 'Tous les champs sont décrits (:count).',
                'some_missing' => ':good champs sur :count sont entièrement décrits.',
                'most_missing' => 'Seulement :good champs sur :count sont entièrement décrits.',
            ],
        ],
        'B1' => [
            'title' => 'L’IA comprend-elle de quel site il s’agit ?',
            'text' => 'Données structurées Schema.org',
            'fix' => 'Ajoutez un bloc JSON-LD avec le type Schema.org adapté à la page : Organization, LocalBusiness, Product, Article ou FAQPage.',
            'notes' => [
                'json_ld' => 'Blocs JSON-LD trouvés : :count.',
                'invalid_json' => 'La page contient du JSON-LD, mais ce n’est pas du JSON valide : les modèles l’ignorent.',
                'microdata_only' => 'Seules des microdonnées sont utilisées ; le JSON-LD est plus facile à lire pour les modèles d’IA.',
                'none' => 'La page ne contient aucune donnée structurée.',
            ],
        ],
        'B2' => [
            'title' => 'Existe-t-il un court guide du site pour l’IA ?',
            'text' => 'Le fichier /llms.txt',
            'fix' => 'Créez /llms.txt : un court résumé du site en Markdown avec des liens vers les pages principales (llmstxt.org).',
            'notes' => [
                'found' => 'Le fichier est disponible.',
                'full_only' => 'Seul /llms-full.txt a été trouvé ; les modèles cherchent d’abord /llms.txt.',
                'none' => 'Ni /llms.txt ni /llms-full.txt n’ont été trouvés.',
            ],
        ],
        'B3' => [
            'title' => 'Une meta description décrit-elle la page ?',
            'text' => '50–160 caractères',
            'fix' => 'Rédigez une meta description qui dit ce que propose la page, de 50 à 160 caractères.',
            'notes' => [
                'none' => 'La page n’a pas de meta description.',
                'good' => ':length caractères, dans la plage :min–:max.',
                'length' => ':length caractères ; la norme est :min–:max.',
            ],
        ],
        'B4' => [
            'title' => 'Un lien vers le site a-t-il bonne allure ?',
            'text' => 'Balises Open Graph',
            'fix' => 'Ajoutez les balises Open Graph manquantes : agents et réseaux sociaux s’en servent pour décrire un lien.',
            'notes' => [
                'all' => 'Les :total balises sont présentes.',
                'none' => 'La page ne contient aucune balise Open Graph.',
                'some' => ':count balises sur :total ; il manque : :missing.',
            ],
        ],
        'B5' => [
            'title' => 'Le site laisse-t-il entrer les robots IA ?',
            'text' => 'Règles de robots.txt',
            'fix' => 'Autorisez dans robots.txt les robots IA par lesquels vous voulez être trouvé, ou supprimez les règles qui les bloquent.',
            'notes' => [
                'no_robots' => 'Il n’y a pas de robots.txt, rien n’est donc bloqué.',
                'allowed' => 'Les robots IA sont autorisés.',
                'all_blocked' => 'Tous les robots IA connus sont bloqués.',
                'some_blocked' => 'Robots IA bloqués : :count.',
            ],
        ],
        'C1' => [
            'title' => 'La connexion est-elle sécurisée ?',
            'text' => 'HTTPS',
            'fix' => 'Passez le site en HTTPS et redirigez http:// vers https:// : WebMCP ne fonctionne que dans un contexte sécurisé.',
            'notes' => [
                'https' => 'La page est servie en HTTPS.',
                'http' => 'La page est servie en HTTP non chiffré, où les navigateurs ne proposent pas WebMCP.',
            ],
        ],
        'C2' => [
            'title' => 'La page limite-t-elle les scripts tiers ?',
            'text' => 'En-tête Content-Security-Policy',
            'fix' => 'Envoyez un en-tête Content-Security-Policy : commencez strict et n’autorisez que les sources réellement utilisées par le site.',
            'notes' => [
                'none' => 'Il n’y a pas d’en-tête Content-Security-Policy.',
                'unsafe_eval' => 'La politique autorise \'unsafe-eval\'.',
                'found' => 'Une politique est définie.',
            ],
        ],
        'C3' => [
            'title' => 'Tout est-il chargé en HTTPS ?',
            'text' => 'Aucune ressource http://',
            'fix' => 'Chargez tous les scripts, styles, images et cadres en https://.',
            'notes' => [
                'not_https' => 'La page n’est pas servie en HTTPS.',
                'none' => 'Toutes les ressources sont chargées en HTTPS.',
                'found' => 'Ressources chargées en HTTP non chiffré : :count.',
            ],
        ],
        'D1' => [
            'title' => 'Les noms disent-ils ce que fait l’outil ?',
            'text' => 'Noms conformes à la spécification',
            'fix' => 'Utilisez des noms de 3 à 128 caractères parmi a–z, 0–9, « _ », « - » et « . » qui commencent par une action : search_products, book_table.',
            'notes' => [
                'no_tools' => 'Il n’y a aucun outil à vérifier.',
                'unreadable' => 'Les noms des outils sont construits à l’exécution et ne peuvent pas être lus sans exécuter le code.',
                'all_good' => 'Tous les noms sont bons (:count).',
                'bad_names' => 'Noms corrects : :good sur :count.',
            ],
        ],
        'D2' => [
            'title' => 'Les descriptions sont-elles assez détaillées ?',
            'text' => 'Au moins 20 caractères',
            'fix' => 'Décrivez en une ou deux phrases ce que fait chaque outil et quand l’utiliser : le modèle choisit un outil d’après sa description.',
            'notes' => [
                'no_tools' => 'Il n’y a aucun outil à vérifier.',
                'unreadable' => 'Les descriptions des outils sont construites à l’exécution et ne peuvent pas être lues sans exécuter le code.',
                'all_good' => 'Toutes les descriptions sont assez longues (:count).',
                'short' => 'Descriptions assez longues : :good sur :count.',
            ],
        ],
        'D3' => [
            'title' => 'L’agent sait-il quels paramètres transmettre ?',
            'text' => 'inputSchema et descriptions des champs',
            'fix' => 'Donnez à chaque outil JavaScript un inputSchema avec des propriétés typées et décrites, et décrivez chaque champ de formulaire avec toolparamdescription.',
            'notes' => [
                'no_tools' => 'Il n’y a aucun outil à vérifier.',
                'unreadable' => 'Les schémas des outils sont construits à l’exécution et ne peuvent pas être lus sans exécuter le code.',
                'all_good' => 'Tous les outils décrivent leurs paramètres (:count).',
                'incomplete' => ':good outils sur :count décrivent entièrement leurs paramètres.',
            ],
        ],
        'D4' => [
            'title' => 'L’agent sait-il quelles actions modifient des données ?',
            'text' => 'L’indication readOnlyHint',
            'fix' => 'Ajoutez des annotations aux outils JavaScript, au moins readOnlyHint: true pour ceux qui ne font que lire des données.',
            'notes' => [
                'no_tools' => 'Il n’y a aucun outil à vérifier.',
                'declarative_only' => 'Les annotations ne concernent que les outils JavaScript.',
                'all_good' => 'Tous les outils ont des annotations (:count).',
                'missing' => ':good outils sur :count ont des annotations.',
            ],
        ],
    ],
];
