<?php

declare(strict_types=1);

return [
    'form' => [
        'label' => 'Dirección de la página',
        'button' => 'Comprobar',
        'hint' => 'Gratis · sin registro · hasta :count comprobaciones por hora',
    ],
    'loading' => [
        'page' => 'Escaneando la página',
        'scripts' => 'Leyendo los scripts del sitio',
        'files' => 'Comprobando robots.txt y llms.txt',
        'checks' => 'Ejecutando 15 comprobaciones',
    ],
    'verdicts' => [
        'ready' => 'Preparado para agentes de IA',
        'almost' => 'Casi preparado para agentes de IA',
        'partly' => 'Parcialmente preparado para agentes de IA',
        'not_ready' => 'No preparado para agentes de IA',
    ],
    'groups' => [
        'B' => [
            'title' => '¿Le encuentra la IA?',
            'text' => 'Lo que ven los modelos de IA y los bots de búsqueda',
        ],
        'A' => [
            'title' => 'Qué puede hacer un agente en el sitio',
            'text' => 'Herramientas WebMCP para agentes de IA en el navegador',
        ],
        'D' => [
            'title' => 'Qué tan claras son las herramientas',
            'text' => 'Nombres, descripciones, esquemas e indicaciones',
        ],
        'C' => [
            'title' => '¿Es seguro para un agente trabajar aquí?',
            'text' => 'HTTPS, límites de scripts, contenido mixto',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => '¿Puede un agente rellenar un formulario?',
            'text' => 'Formularios con toolname y tooldescription',
            'fix' => 'Añada toolname y tooldescription a un formulario que realice una acción útil (búsqueda, reserva, pedido) y describa cada campo con toolparamdescription.',
            'notes' => [
                'none' => 'La página no tiene formularios con el atributo toolname.',
                'imperative_only' => 'El sitio registra sus herramientas con JavaScript, así que los formularios no son necesarios.',
                'no_description' => 'Formularios con toolname pero sin tooldescription: :count. Un agente no sabrá qué hacen.',
                'found' => 'Formularios disponibles para los agentes de IA como herramientas: :count.',
            ],
        ],
        'A2' => [
            'title' => '¿Ofrece el sitio acciones al agente desde JavaScript?',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'Registre las herramientas con JavaScript mediante document.modelContext.registerTool(). navigator.modelContext es la ubicación antigua de la API, obsoleta desde mediados de 2026.',
            'notes' => [
                'none' => 'No se encontraron llamadas a registerTool() en los scripts del sitio (:scripts). El código que se carga solo tras una acción del usuario no se comprueba.',
                'declarative_only' => 'El sitio ofrece sus herramientas como formularios, así que el registro con JavaScript no es necesario.',
                'deprecated' => 'Herramientas encontradas: :count, pero el código usa navigator.modelContext, la ubicación antigua de la API.',
                'found' => 'Herramientas registradas con JavaScript: :count.',
            ],
        ],
        'A3' => [
            'title' => '¿Son claros los campos de los formularios para un agente?',
            'text' => 'name y toolparamdescription en cada campo',
            'fix' => 'Dé a cada campo de un formulario-herramienta un name y un toolparamdescription; use tipos exactos (email, number, date) y required o pattern cuando los valores siguen reglas.',
            'notes' => [
                'no_forms' => 'La página no tiene formularios-herramienta.',
                'no_fields' => 'Los formularios-herramienta no tienen campos que un agente pueda rellenar.',
                'all_good' => 'Todos los campos están descritos (:count).',
                'some_missing' => ':good de :count campos están descritos por completo.',
                'most_missing' => 'Solo :good de :count campos están descritos por completo.',
            ],
        ],
        'B1' => [
            'title' => '¿Entiende la IA qué sitio es este?',
            'text' => 'Datos estructurados Schema.org',
            'fix' => 'Añada un bloque JSON-LD con el tipo de Schema.org adecuado a la página: Organization, LocalBusiness, Product, Article o FAQPage.',
            'notes' => [
                'json_ld' => 'Bloques JSON-LD encontrados: :count.',
                'invalid_json' => 'La página tiene JSON-LD, pero no es JSON válido, así que los modelos lo ignoran.',
                'microdata_only' => 'Solo se usan microdatos; el JSON-LD es más fácil de leer para los modelos de IA.',
                'none' => 'La página no tiene datos estructurados.',
            ],
        ],
        'B2' => [
            'title' => '¿Hay una guía breve del sitio para la IA?',
            'text' => 'El archivo /llms.txt',
            'fix' => 'Cree /llms.txt: un breve resumen del sitio en Markdown con enlaces a las páginas principales (llmstxt.org).',
            'notes' => [
                'found' => 'El archivo está disponible.',
                'full_only' => 'Solo se encontró /llms-full.txt; los modelos buscan primero /llms.txt.',
                'none' => 'No se encontró ni /llms.txt ni /llms-full.txt.',
            ],
        ],
        'B3' => [
            'title' => '¿Describe la página una meta description?',
            'text' => '50–160 caracteres',
            'fix' => 'Escriba una meta description que diga lo que ofrece la página, de 50 a 160 caracteres.',
            'notes' => [
                'none' => 'La página no tiene meta description.',
                'good' => ':length caracteres, dentro de :min–:max.',
                'length' => ':length caracteres; lo recomendado es :min–:max.',
            ],
        ],
        'B4' => [
            'title' => '¿Se ve bien un enlace al sitio?',
            'text' => 'Etiquetas Open Graph',
            'fix' => 'Añada las etiquetas Open Graph que faltan: los agentes y las redes sociales las usan para describir un enlace.',
            'notes' => [
                'all' => 'Están las :total etiquetas.',
                'none' => 'La página no tiene etiquetas Open Graph.',
                'some' => ':count de :total etiquetas; faltan: :missing.',
            ],
        ],
        'B5' => [
            'title' => '¿Deja entrar el sitio a los bots de IA?',
            'text' => 'Reglas de robots.txt',
            'fix' => 'Permita en robots.txt los rastreadores de IA por los que quiere ser encontrado, o elimine las reglas que los bloquean.',
            'notes' => [
                'no_robots' => 'No hay robots.txt, así que no hay nada bloqueado.',
                'allowed' => 'Los rastreadores de IA están permitidos.',
                'all_blocked' => 'Todos los rastreadores de IA conocidos están bloqueados.',
                'some_blocked' => 'Rastreadores de IA bloqueados: :count.',
            ],
        ],
        'C1' => [
            'title' => '¿Es segura la conexión?',
            'text' => 'HTTPS',
            'fix' => 'Pase el sitio a HTTPS y redirija http:// a https://: WebMCP solo funciona en un contexto seguro.',
            'notes' => [
                'https' => 'La página se sirve por HTTPS.',
                'http' => 'La página se sirve por HTTP sin cifrar, donde los navegadores no ofrecen WebMCP.',
            ],
        ],
        'C2' => [
            'title' => '¿Limita la página los scripts de terceros?',
            'text' => 'Cabecera Content-Security-Policy',
            'fix' => 'Envíe una cabecera Content-Security-Policy: empiece con una política estricta y permita solo los orígenes que el sitio usa de verdad.',
            'notes' => [
                'none' => 'No hay cabecera Content-Security-Policy.',
                'unsafe_eval' => 'La política permite \'unsafe-eval\'.',
                'found' => 'Hay una política definida.',
            ],
        ],
        'C3' => [
            'title' => '¿Se carga todo por HTTPS?',
            'text' => 'Sin recursos http://',
            'fix' => 'Cargue todos los scripts, estilos, imágenes y marcos por https://.',
            'notes' => [
                'not_https' => 'La página no se sirve por HTTPS.',
                'none' => 'Todos los recursos se cargan por HTTPS.',
                'found' => 'Recursos cargados por HTTP sin cifrar: :count.',
            ],
        ],
        'D1' => [
            'title' => '¿Dicen los nombres qué hace la herramienta?',
            'text' => 'Nombres según la especificación',
            'fix' => 'Use nombres de 3–128 caracteres de a–z, 0–9, «_», «-» y «.» que empiecen por una acción: search_products, book_table.',
            'notes' => [
                'no_tools' => 'No hay herramientas que comprobar.',
                'unreadable' => 'Los nombres de las herramientas se construyen en ejecución y no se pueden leer sin ejecutar el código.',
                'all_good' => 'Todos los nombres son buenos (:count).',
                'bad_names' => 'Nombres correctos: :good de :count.',
            ],
        ],
        'D2' => [
            'title' => '¿Son las descripciones lo bastante detalladas?',
            'text' => 'Al menos 20 caracteres',
            'fix' => 'Describa en una o dos frases qué hace cada herramienta y cuándo usarla: el modelo elige la herramienta por su descripción.',
            'notes' => [
                'no_tools' => 'No hay herramientas que comprobar.',
                'unreadable' => 'Las descripciones de las herramientas se construyen en ejecución y no se pueden leer sin ejecutar el código.',
                'all_good' => 'Todas las descripciones son lo bastante largas (:count).',
                'short' => 'Descripciones lo bastante largas: :good de :count.',
            ],
        ],
        'D3' => [
            'title' => '¿Sabe el agente qué parámetros pasar?',
            'text' => 'inputSchema y descripciones de campos',
            'fix' => 'Dé a cada herramienta JavaScript un inputSchema con propiedades tipadas y descritas, y describa cada campo de formulario con toolparamdescription.',
            'notes' => [
                'no_tools' => 'No hay herramientas que comprobar.',
                'unreadable' => 'Los esquemas de las herramientas se construyen en ejecución y no se pueden leer sin ejecutar el código.',
                'all_good' => 'Todas las herramientas describen sus parámetros (:count).',
                'incomplete' => ':good de :count herramientas describen sus parámetros por completo.',
            ],
        ],
        'D4' => [
            'title' => '¿Sabe el agente qué acciones cambian datos?',
            'text' => 'La indicación readOnlyHint',
            'fix' => 'Añada anotaciones a las herramientas JavaScript, al menos readOnlyHint: true para las que solo leen datos.',
            'notes' => [
                'no_tools' => 'No hay herramientas que comprobar.',
                'declarative_only' => 'Las anotaciones solo se aplican a las herramientas JavaScript.',
                'all_good' => 'Todas las herramientas tienen anotaciones (:count).',
                'missing' => ':good de :count herramientas tienen anotaciones.',
            ],
        ],
    ],
];
