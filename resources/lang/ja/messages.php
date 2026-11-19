<?php

declare(strict_types=1);

return [
    'form' => [
        'label' => 'ページのURL',
        'button' => 'チェック',
        'hint' => '無料 · 登録不要 · 1時間に最大:count回まで',
    ],
    'loading' => [
        'page' => 'ページをスキャンしています',
        'scripts' => 'サイトのスクリプトを読み込んでいます',
        'files' => 'robots.txt と llms.txt を確認しています',
        'checks' => '15項目をチェックしています',
    ],
    'verdicts' => [
        'ready' => 'AIエージェント対応済み',
        'almost' => 'AIエージェントにほぼ対応',
        'partly' => 'AIエージェントに一部対応',
        'not_ready' => 'AIエージェント未対応',
    ],
    'groups' => [
        'B' => [
            'title' => 'AIに見つけてもらえるか',
            'text' => 'AIモデルと検索ボットから見えるもの',
        ],
        'A' => [
            'title' => 'エージェントがサイトでできること',
            'text' => 'ブラウザ内のAIエージェント向けWebMCPツール',
        ],
        'D' => [
            'title' => 'ツールのわかりやすさ',
            'text' => '名前、説明、スキーマ、ヒント',
        ],
        'C' => [
            'title' => 'エージェントにとって安全か',
            'text' => 'HTTPS、スクリプトの制限、混在コンテンツ',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => 'エージェントはフォームに入力できるか？',
            'text' => 'toolname と tooldescription のあるフォーム',
            'fix' => '検索・予約・注文など役立つ操作を行うフォームに toolname と tooldescription を追加し、各フィールドを toolparamdescription で説明してください。',
            'notes' => [
                'none' => 'ページに toolname 属性を持つフォームはありません。',
                'imperative_only' => 'サイトは JavaScript でツールを登録しているため、フォームは必須ではありません。',
                'no_description' => 'toolname はあるが tooldescription がないフォーム: :count。エージェントには何をするフォームか分かりません。',
                'found' => 'AIエージェントがツールとして使えるフォーム: :count。',
            ],
        ],
        'A2' => [
            'title' => 'サイトはJavaScriptでエージェントに操作を提供しているか？',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'document.modelContext.registerTool() で JavaScript からツールを登録してください。navigator.modelContext は API の旧位置で、2026年半ばから非推奨です。',
            'notes' => [
                'none' => 'サイトのスクリプト（:scripts件）に registerTool() の呼び出しは見つかりませんでした。ユーザー操作の後に読み込まれるコードはチェックしていません。',
                'declarative_only' => 'サイトはフォームでツールを提供しているため、JavaScript での登録は必須ではありません。',
                'deprecated' => 'ツールが見つかりました（:count件）が、コードは API の旧位置 navigator.modelContext を使っています。',
                'found' => 'JavaScript で登録されたツール: :count。',
            ],
        ],
        'A3' => [
            'title' => 'フォーム項目はエージェントにわかりやすいか？',
            'text' => '各項目の name と toolparamdescription',
            'fix' => 'ツール用フォームの各項目に name と toolparamdescription を付け、正確な型（email、number、date）と、値に規則がある場合は required や pattern を使ってください。',
            'notes' => [
                'no_forms' => 'ページにツール用フォームはありません。',
                'no_fields' => 'ツール用フォームにエージェントが入力できる項目がありません。',
                'all_good' => 'すべての項目が説明されています（:count件）。',
                'some_missing' => ':count件中 :good件の項目が完全に説明されています。',
                'most_missing' => ':count件中 :good件の項目しか完全に説明されていません。',
            ],
        ],
        'B1' => [
            'title' => 'AIはどんなサイトか理解できるか？',
            'text' => 'Schema.org 構造化データ',
            'fix' => 'ページに合った Schema.org の型（Organization、LocalBusiness、Product、Article、FAQPage など）で JSON-LD ブロックを追加してください。',
            'notes' => [
                'json_ld' => 'JSON-LD ブロック: :count件。',
                'invalid_json' => 'ページに JSON-LD はありますが、正しい JSON ではないためモデルに無視されます。',
                'microdata_only' => 'マイクロデータのみ使われています。JSON-LD のほうが AI モデルには読みやすいです。',
                'none' => 'ページに構造化データはありません。',
            ],
        ],
        'B2' => [
            'title' => 'AI向けの短いサイトガイドはあるか？',
            'text' => '/llms.txt ファイル',
            'fix' => '/llms.txt を作成してください。主要ページへのリンクを含む、Markdown による短いサイト概要です（llmstxt.org）。',
            'notes' => [
                'found' => 'ファイルは利用できます。',
                'full_only' => '/llms-full.txt のみ見つかりました。モデルはまず /llms.txt を探します。',
                'none' => '/llms.txt も /llms-full.txt も見つかりませんでした。',
            ],
        ],
        'B3' => [
            'title' => 'meta description はページを説明しているか？',
            'text' => '50～160文字',
            'fix' => 'ページが何を提供するかを伝える meta description を50～160文字で書いてください。',
            'notes' => [
                'none' => 'ページに meta description がありません。',
                'good' => ':length文字で、:min～:max の範囲内です。',
                'length' => ':length文字です。推奨は :min～:max です。',
            ],
        ],
        'B4' => [
            'title' => 'サイトへのリンクは見栄えがよいか？',
            'text' => 'Open Graph タグ',
            'fix' => '足りない Open Graph タグを追加してください。エージェントや SNS はこれでリンクを説明します。',
            'notes' => [
                'all' => ':total個のタグがすべてあります。',
                'none' => 'ページに Open Graph タグはありません。',
                'some' => ':total個中 :count個。不足: :missing。',
            ],
        ],
        'B5' => [
            'title' => 'サイトはAIボットを受け入れているか？',
            'text' => 'robots.txt のルール',
            'fix' => '見つけてほしい AI クローラーを robots.txt で許可するか、ブロックしているルールを削除してください。',
            'notes' => [
                'no_robots' => 'robots.txt がないため、何もブロックされていません。',
                'allowed' => 'AI クローラーは許可されています。',
                'all_blocked' => '既知の AI クローラーはすべてブロックされています。',
                'some_blocked' => 'ブロックされている AI クローラー: :count。',
            ],
        ],
        'C1' => [
            'title' => '接続は安全か？',
            'text' => 'HTTPS',
            'fix' => 'サイトを HTTPS に移行し、http:// を https:// にリダイレクトしてください。WebMCP は安全なコンテキストでのみ動作します。',
            'notes' => [
                'https' => 'ページは HTTPS で配信されています。',
                'http' => 'ページは暗号化されていない HTTP で配信されており、ブラウザはそこで WebMCP を提供しません。',
            ],
        ],
        'C2' => [
            'title' => 'ページは外部スクリプトを制限しているか？',
            'text' => 'Content-Security-Policy ヘッダー',
            'fix' => 'Content-Security-Policy ヘッダーを送信してください。厳しい設定から始め、サイトが実際に使うソースだけを許可します。',
            'notes' => [
                'none' => 'Content-Security-Policy ヘッダーがありません。',
                'unsafe_eval' => 'ポリシーが \'unsafe-eval\' を許可しています。',
                'found' => 'ポリシーが設定されています。',
            ],
        ],
        'C3' => [
            'title' => 'すべてHTTPSで読み込まれているか？',
            'text' => 'http:// のリソースなし',
            'fix' => 'すべてのスクリプト・スタイル・画像・フレームを https:// で読み込んでください。',
            'notes' => [
                'not_https' => 'ページは HTTPS で配信されていません。',
                'none' => 'すべてのリソースが HTTPS で読み込まれています。',
                'found' => '暗号化されていない HTTP で読み込まれるリソース: :count。',
            ],
        ],
        'D1' => [
            'title' => '名前はツールの動作を表しているか？',
            'text' => '仕様に沿った名前',
            'fix' => 'a～z、0～9、「_」「-」「.」からなる3～128文字で、動作から始まる名前を使ってください（search_products、book_table など）。',
            'notes' => [
                'no_tools' => 'チェックするツールがありません。',
                'unreadable' => 'ツール名は実行時に組み立てられるため、コードを実行しないと読めません。',
                'all_good' => 'すべての名前が適切です（:count件）。',
                'bad_names' => '適切な名前: :count件中 :good件。',
            ],
        ],
        'D2' => [
            'title' => '説明は十分に詳しいか？',
            'text' => '20文字以上',
            'fix' => '各ツールが何をするか、いつ使うかを1～2文で説明してください。モデルは説明を見てツールを選びます。',
            'notes' => [
                'no_tools' => 'チェックするツールがありません。',
                'unreadable' => 'ツールの説明は実行時に組み立てられるため、コードを実行しないと読めません。',
                'all_good' => 'すべての説明が十分な長さです（:count件）。',
                'short' => '十分な長さの説明: :count件中 :good件。',
            ],
        ],
        'D3' => [
            'title' => 'エージェントは渡すべきパラメーターを知っているか？',
            'text' => 'inputSchema と項目の説明',
            'fix' => '各 JavaScript ツールに型と説明付きのプロパティを持つ inputSchema を付け、各フォーム項目を toolparamdescription で説明してください。',
            'notes' => [
                'no_tools' => 'チェックするツールがありません。',
                'unreadable' => 'ツールのスキーマは実行時に組み立てられるため、コードを実行しないと読めません。',
                'all_good' => 'すべてのツールがパラメーターを説明しています（:count件）。',
                'incomplete' => ':count件中 :good件のツールがパラメーターを完全に説明しています。',
            ],
        ],
        'D4' => [
            'title' => 'エージェントはデータを変更する操作を知っているか？',
            'text' => 'readOnlyHint のヒント',
            'fix' => 'JavaScript ツールにアノテーションを追加してください。データを読むだけのツールには少なくとも readOnlyHint: true を付けます。',
            'notes' => [
                'no_tools' => 'チェックするツールがありません。',
                'declarative_only' => 'アノテーションは JavaScript ツールにのみ適用されます。',
                'all_good' => 'すべてのツールにアノテーションがあります（:count件）。',
                'missing' => ':count件中 :good件のツールにアノテーションがあります。',
            ],
        ],
    ],
];
