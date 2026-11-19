<?php

return [
    'form' => [
        'label' => '页面地址',
        'button' => '检查',
        'hint' => '免费 · 无需注册 · 每小时最多 :count 次检查',
    ],
    'loading' => [
        'page' => '正在扫描页面',
        'scripts' => '正在读取网站脚本',
        'files' => '正在检查 robots.txt 和 llms.txt',
        'checks' => '正在执行 15 项检查',
    ],
    'verdicts' => [
        'ready' => '已为 AI 代理做好准备',
        'almost' => '几乎已为 AI 代理做好准备',
        'partly' => '部分为 AI 代理做好准备',
        'not_ready' => '尚未为 AI 代理做好准备',
    ],
    'groups' => [
        'B' => [
            'title' => 'AI 能找到您吗',
            'text' => 'AI 模型和搜索机器人看到的内容',
        ],
        'A' => [
            'title' => '代理能在网站上做什么',
            'text' => '面向浏览器中 AI 代理的 WebMCP 工具',
        ],
        'D' => [
            'title' => '工具有多清晰',
            'text' => '名称、描述、模式和提示',
        ],
        'C' => [
            'title' => '代理在这里安全吗',
            'text' => 'HTTPS、脚本限制、混合内容',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => '代理能填写表单吗？',
            'text' => '带 toolname 和 tooldescription 的表单',
            'fix' => '为执行有用操作（搜索、预订、下单）的表单添加 toolname 和 tooldescription，并用 toolparamdescription 描述每个字段。',
            'notes' => [
                'none' => '页面上没有带 toolname 属性的表单。',
                'imperative_only' => '网站通过 JavaScript 注册工具，因此不需要表单。',
                'no_description' => '有 toolname 但没有 tooldescription 的表单：:count 个。代理不知道它们的用途。',
                'found' => '可作为工具供 AI 代理使用的表单：:count 个。',
            ],
        ],
        'A2' => [
            'title' => '网站通过 JavaScript 为代理提供操作吗？',
            'text' => 'document.modelContext.registerTool()',
            'fix' => '通过 document.modelContext.registerTool() 用 JavaScript 注册工具。navigator.modelContext 是 API 的旧位置，自 2026 年年中起已弃用。',
            'notes' => [
                'none' => '在网站脚本（:scripts 个）中未找到 registerTool() 调用。仅在用户操作后加载的代码不会被检查。',
                'declarative_only' => '网站以表单形式提供工具，因此不需要用 JavaScript 注册。',
                'deprecated' => '找到工具 :count 个，但代码使用的是 API 的旧位置 navigator.modelContext。',
                'found' => '通过 JavaScript 注册的工具：:count 个。',
            ],
        ],
        'A3' => [
            'title' => '表单字段对代理清晰吗？',
            'text' => '每个字段都有 name 和 toolparamdescription',
            'fix' => '为工具表单的每个字段设置 name 和 toolparamdescription；使用准确的类型（email、number、date），值有规则时使用 required 或 pattern。',
            'notes' => [
                'no_forms' => '页面上没有工具表单。',
                'no_fields' => '工具表单中没有代理可以填写的字段。',
                'all_good' => '所有字段都有描述（:count 个）。',
                'some_missing' => ':count 个字段中有 :good 个描述完整。',
                'most_missing' => ':count 个字段中只有 :good 个描述完整。',
            ],
        ],
        'B1' => [
            'title' => 'AI 能理解这是什么网站吗？',
            'text' => 'Schema.org 结构化数据',
            'fix' => '添加与页面相符的 Schema.org 类型的 JSON-LD 块：Organization、LocalBusiness、Product、Article 或 FAQPage。',
            'notes' => [
                'json_ld' => '找到 JSON-LD 块：:count 个。',
                'invalid_json' => '页面上有 JSON-LD，但不是有效的 JSON，模型会忽略它。',
                'microdata_only' => '仅使用了微数据；JSON-LD 更便于 AI 模型读取。',
                'none' => '页面上没有结构化数据。',
            ],
        ],
        'B2' => [
            'title' => '有给 AI 的简短网站指南吗？',
            'text' => '/llms.txt 文件',
            'fix' => '创建 /llms.txt：用 Markdown 写的简短网站概要，并附上主要页面的链接（llmstxt.org）。',
            'notes' => [
                'found' => '文件可以访问。',
                'full_only' => '只找到 /llms-full.txt；模型会首先查找 /llms.txt。',
                'none' => '未找到 /llms.txt 和 /llms-full.txt。',
            ],
        ],
        'B3' => [
            'title' => 'meta description 描述了页面吗？',
            'text' => '50–160 个字符',
            'fix' => '编写一个说明页面提供什么内容的 meta description，长度 50–160 个字符。',
            'notes' => [
                'none' => '页面没有 meta description。',
                'good' => ':length 个字符，在 :min–:max 范围内。',
                'length' => ':length 个字符；建议 :min–:max。',
            ],
        ],
        'B4' => [
            'title' => '网站链接看起来好看吗？',
            'text' => 'Open Graph 标签',
            'fix' => '添加缺少的 Open Graph 标签：代理和社交网络用它们描述链接。',
            'notes' => [
                'all' => ':total 个标签齐全。',
                'none' => '页面上没有 Open Graph 标签。',
                'some' => ':total 个标签中有 :count 个；缺少：:missing。',
            ],
        ],
        'B5' => [
            'title' => '网站允许 AI 机器人访问吗？',
            'text' => 'robots.txt 规则',
            'fix' => '在 robots.txt 中允许您希望被其找到的 AI 爬虫，或删除阻止它们的规则。',
            'notes' => [
                'no_robots' => '没有 robots.txt，因此没有任何内容被阻止。',
                'allowed' => 'AI 爬虫可以访问。',
                'all_blocked' => '所有已知的 AI 爬虫都被阻止。',
                'some_blocked' => '被阻止的 AI 爬虫：:count 个。',
            ],
        ],
        'C1' => [
            'title' => '连接安全吗？',
            'text' => 'HTTPS',
            'fix' => '将网站迁移到 HTTPS，并把 http:// 重定向到 https://：WebMCP 只能在安全上下文中运行。',
            'notes' => [
                'https' => '页面通过 HTTPS 提供。',
                'http' => '页面通过未加密的 HTTP 提供，浏览器在这种情况下不提供 WebMCP。',
            ],
        ],
        'C2' => [
            'title' => '页面限制第三方脚本吗？',
            'text' => 'Content-Security-Policy 标头',
            'fix' => '发送 Content-Security-Policy 标头：从严格的策略开始，只允许网站实际使用的来源。',
            'notes' => [
                'none' => '没有 Content-Security-Policy 标头。',
                'unsafe_eval' => '策略允许 \'unsafe-eval\'。',
                'found' => '已设置策略。',
            ],
        ],
        'C3' => [
            'title' => '所有内容都通过 HTTPS 加载吗？',
            'text' => '没有 http:// 资源',
            'fix' => '通过 https:// 加载所有脚本、样式、图片和框架。',
            'notes' => [
                'not_https' => '页面不是通过 HTTPS 提供的。',
                'none' => '所有资源都通过 HTTPS 加载。',
                'found' => '通过未加密 HTTP 加载的资源：:count 个。',
            ],
        ],
        'D1' => [
            'title' => '名称说明了工具的作用吗？',
            'text' => '符合规范的名称',
            'fix' => '使用由 a–z、0–9、"_"、"-" 和 "." 组成的 3–128 个字符、以动作开头的名称：search_products、book_table。',
            'notes' => [
                'no_tools' => '没有可检查的工具。',
                'unreadable' => '工具名称在运行时生成，不运行代码就无法读取。',
                'all_good' => '所有名称都合适（:count 个）。',
                'bad_names' => '合适的名称：:count 个中有 :good 个。',
            ],
        ],
        'D2' => [
            'title' => '描述足够详细吗？',
            'text' => '至少 20 个字符',
            'fix' => '用一两句话说明每个工具的作用以及何时使用：模型根据描述选择工具。',
            'notes' => [
                'no_tools' => '没有可检查的工具。',
                'unreadable' => '工具描述在运行时生成，不运行代码就无法读取。',
                'all_good' => '所有描述都足够长（:count 个）。',
                'short' => '足够长的描述：:count 个中有 :good 个。',
            ],
        ],
        'D3' => [
            'title' => '代理知道要传哪些参数吗？',
            'text' => 'inputSchema 和字段描述',
            'fix' => '为每个 JavaScript 工具提供带有类型和描述属性的 inputSchema，并用 toolparamdescription 描述每个表单字段。',
            'notes' => [
                'no_tools' => '没有可检查的工具。',
                'unreadable' => '工具模式在运行时生成，不运行代码就无法读取。',
                'all_good' => '所有工具都描述了参数（:count 个）。',
                'incomplete' => ':count 个工具中有 :good 个完整描述了参数。',
            ],
        ],
        'D4' => [
            'title' => '代理知道哪些操作会修改数据吗？',
            'text' => 'readOnlyHint 提示',
            'fix' => '为 JavaScript 工具添加注解，至少为只读取数据的工具设置 readOnlyHint: true。',
            'notes' => [
                'no_tools' => '没有可检查的工具。',
                'declarative_only' => '注解只适用于 JavaScript 工具。',
                'all_good' => '所有工具都有注解（:count 个）。',
                'missing' => ':count 个工具中有 :good 个有注解。',
            ],
        ],
    ],
];
