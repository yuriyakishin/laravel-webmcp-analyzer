<?php

return [
    'form' => [
        'label' => 'Endereço da página',
        'button' => 'Verificar',
        'hint' => 'Grátis · sem registo · até :count verificações por hora',
    ],
    'loading' => [
        'page' => 'A analisar a página',
        'scripts' => 'A ler os scripts do site',
        'files' => 'A verificar robots.txt e llms.txt',
        'checks' => 'A executar 15 verificações',
    ],
    'verdicts' => [
        'ready' => 'Preparado para agentes de IA',
        'almost' => 'Quase preparado para agentes de IA',
        'partly' => 'Parcialmente preparado para agentes de IA',
        'not_ready' => 'Não preparado para agentes de IA',
    ],
    'groups' => [
        'B' => [
            'title' => 'A IA encontra-o?',
            'text' => 'O que veem os modelos de IA e os bots de pesquisa',
        ],
        'A' => [
            'title' => 'O que um agente pode fazer no site',
            'text' => 'Ferramentas WebMCP para agentes de IA no navegador',
        ],
        'D' => [
            'title' => 'Quão claras são as ferramentas',
            'text' => 'Nomes, descrições, esquemas e indicações',
        ],
        'C' => [
            'title' => 'É seguro para um agente trabalhar aqui?',
            'text' => 'HTTPS, limites de scripts, conteúdo misto',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => 'Um agente consegue preencher um formulário?',
            'text' => 'Formulários com toolname e tooldescription',
            'fix' => 'Adicione toolname e tooldescription a um formulário que execute uma ação útil (pesquisa, reserva, encomenda) e descreva cada campo com toolparamdescription.',
            'notes' => [
                'none' => 'A página não tem formulários com o atributo toolname.',
                'imperative_only' => 'O site regista as suas ferramentas em JavaScript, por isso os formulários não são necessários.',
                'no_description' => 'Formulários com toolname mas sem tooldescription: :count. Um agente não saberá o que fazem.',
                'found' => 'Formulários disponíveis para os agentes de IA como ferramentas: :count.',
            ],
        ],
        'A2' => [
            'title' => 'O site dá ações ao agente via JavaScript?',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'Registe as ferramentas em JavaScript com document.modelContext.registerTool(). navigator.modelContext é a localização antiga da API, obsoleta desde meados de 2026.',
            'notes' => [
                'none' => 'Não foram encontradas chamadas a registerTool() nos scripts do site (:scripts). O código carregado só após uma ação do utilizador não é verificado.',
                'declarative_only' => 'O site oferece as suas ferramentas como formulários, por isso o registo em JavaScript não é necessário.',
                'deprecated' => 'Ferramentas encontradas: :count, mas o código usa navigator.modelContext, a localização antiga da API.',
                'found' => 'Ferramentas registadas em JavaScript: :count.',
            ],
        ],
        'A3' => [
            'title' => 'Os campos dos formulários são claros para um agente?',
            'text' => 'name e toolparamdescription em cada campo',
            'fix' => 'Dê a cada campo de um formulário-ferramenta um name e um toolparamdescription; use tipos exatos (email, number, date) e required ou pattern quando os valores seguem regras.',
            'notes' => [
                'no_forms' => 'A página não tem formulários-ferramenta.',
                'no_fields' => 'Os formulários-ferramenta não têm campos que um agente possa preencher.',
                'all_good' => 'Todos os campos estão descritos (:count).',
                'some_missing' => ':good de :count campos estão totalmente descritos.',
                'most_missing' => 'Apenas :good de :count campos estão totalmente descritos.',
            ],
        ],
        'B1' => [
            'title' => 'A IA percebe que site é este?',
            'text' => 'Dados estruturados Schema.org',
            'fix' => 'Adicione um bloco JSON-LD com o tipo Schema.org adequado à página: Organization, LocalBusiness, Product, Article ou FAQPage.',
            'notes' => [
                'json_ld' => 'Blocos JSON-LD encontrados: :count.',
                'invalid_json' => 'A página tem JSON-LD, mas não é JSON válido, por isso os modelos ignoram-no.',
                'microdata_only' => 'Só são usados microdados; o JSON-LD é mais fácil de ler para os modelos de IA.',
                'none' => 'A página não tem dados estruturados.',
            ],
        ],
        'B2' => [
            'title' => 'Há um guia curto do site para a IA?',
            'text' => 'O ficheiro /llms.txt',
            'fix' => 'Crie /llms.txt: um breve resumo do site em Markdown com ligações para as páginas principais (llmstxt.org).',
            'notes' => [
                'found' => 'O ficheiro está disponível.',
                'full_only' => 'Só foi encontrado /llms-full.txt; os modelos procuram primeiro /llms.txt.',
                'none' => 'Não foi encontrado /llms.txt nem /llms-full.txt.',
            ],
        ],
        'B3' => [
            'title' => 'Uma meta description descreve a página?',
            'text' => '50–160 caracteres',
            'fix' => 'Escreva uma meta description que diga o que a página oferece, com 50–160 caracteres.',
            'notes' => [
                'none' => 'A página não tem meta description.',
                'good' => ':length caracteres, dentro de :min–:max.',
                'length' => ':length caracteres; o recomendado é :min–:max.',
            ],
        ],
        'B4' => [
            'title' => 'Uma ligação para o site tem bom aspeto?',
            'text' => 'Etiquetas Open Graph',
            'fix' => 'Adicione as etiquetas Open Graph em falta: agentes e redes sociais usam-nas para descrever uma ligação.',
            'notes' => [
                'all' => 'As :total etiquetas estão presentes.',
                'none' => 'A página não tem etiquetas Open Graph.',
                'some' => ':count de :total etiquetas; faltam: :missing.',
            ],
        ],
        'B5' => [
            'title' => 'O site deixa entrar os bots de IA?',
            'text' => 'Regras do robots.txt',
            'fix' => 'Permita no robots.txt os rastreadores de IA pelos quais quer ser encontrado, ou remova as regras que os bloqueiam.',
            'notes' => [
                'no_robots' => 'Não há robots.txt, por isso nada está bloqueado.',
                'allowed' => 'Os rastreadores de IA estão permitidos.',
                'all_blocked' => 'Todos os rastreadores de IA conhecidos estão bloqueados.',
                'some_blocked' => 'Rastreadores de IA bloqueados: :count.',
            ],
        ],
        'C1' => [
            'title' => 'A ligação é segura?',
            'text' => 'HTTPS',
            'fix' => 'Mude o site para HTTPS e redirecione http:// para https://: o WebMCP só funciona num contexto seguro.',
            'notes' => [
                'https' => 'A página é servida por HTTPS.',
                'http' => 'A página é servida por HTTP sem encriptação, onde os navegadores não oferecem WebMCP.',
            ],
        ],
        'C2' => [
            'title' => 'A página limita scripts de terceiros?',
            'text' => 'Cabeçalho Content-Security-Policy',
            'fix' => 'Envie um cabeçalho Content-Security-Policy: comece com uma política rigorosa e permita só as origens que o site realmente usa.',
            'notes' => [
                'none' => 'Não há cabeçalho Content-Security-Policy.',
                'unsafe_eval' => 'A política permite \'unsafe-eval\'.',
                'found' => 'Está definida uma política.',
            ],
        ],
        'C3' => [
            'title' => 'Tudo é carregado por HTTPS?',
            'text' => 'Sem recursos http://',
            'fix' => 'Carregue todos os scripts, estilos, imagens e frames por https://.',
            'notes' => [
                'not_https' => 'A página não é servida por HTTPS.',
                'none' => 'Todos os recursos são carregados por HTTPS.',
                'found' => 'Recursos carregados por HTTP sem encriptação: :count.',
            ],
        ],
        'D1' => [
            'title' => 'Os nomes dizem o que a ferramenta faz?',
            'text' => 'Nomes segundo a especificação',
            'fix' => 'Use nomes de 3–128 caracteres de a–z, 0–9, «_», «-» e «.» que comecem por uma ação: search_products, book_table.',
            'notes' => [
                'no_tools' => 'Não há ferramentas para verificar.',
                'unreadable' => 'Os nomes das ferramentas são criados em execução e não podem ser lidos sem executar o código.',
                'all_good' => 'Todos os nomes são bons (:count).',
                'bad_names' => 'Nomes bons: :good de :count.',
            ],
        ],
        'D2' => [
            'title' => 'As descrições são suficientemente detalhadas?',
            'text' => 'Pelo menos 20 caracteres',
            'fix' => 'Descreva numa ou duas frases o que cada ferramenta faz e quando usá-la: o modelo escolhe a ferramenta pela descrição.',
            'notes' => [
                'no_tools' => 'Não há ferramentas para verificar.',
                'unreadable' => 'As descrições das ferramentas são criadas em execução e não podem ser lidas sem executar o código.',
                'all_good' => 'Todas as descrições são suficientemente longas (:count).',
                'short' => 'Descrições suficientemente longas: :good de :count.',
            ],
        ],
        'D3' => [
            'title' => 'O agente sabe que parâmetros passar?',
            'text' => 'inputSchema e descrições dos campos',
            'fix' => 'Dê a cada ferramenta JavaScript um inputSchema com propriedades tipadas e descritas, e descreva cada campo de formulário com toolparamdescription.',
            'notes' => [
                'no_tools' => 'Não há ferramentas para verificar.',
                'unreadable' => 'Os esquemas das ferramentas são criados em execução e não podem ser lidos sem executar o código.',
                'all_good' => 'Todas as ferramentas descrevem os seus parâmetros (:count).',
                'incomplete' => ':good de :count ferramentas descrevem totalmente os seus parâmetros.',
            ],
        ],
        'D4' => [
            'title' => 'O agente sabe que ações alteram dados?',
            'text' => 'A indicação readOnlyHint',
            'fix' => 'Adicione anotações às ferramentas JavaScript, pelo menos readOnlyHint: true para as que só leem dados.',
            'notes' => [
                'no_tools' => 'Não há ferramentas para verificar.',
                'declarative_only' => 'As anotações aplicam-se só às ferramentas JavaScript.',
                'all_good' => 'Todas as ferramentas têm anotações (:count).',
                'missing' => ':good de :count ferramentas têm anotações.',
            ],
        ],
    ],
];
