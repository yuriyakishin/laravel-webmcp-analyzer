<?php

return [
    'form' => [
        'label' => 'Sayfa adresi',
        'button' => 'Kontrol et',
        'hint' => 'Ücretsiz · kayıt gerekmez · saatte en fazla :count kontrol',
    ],
    'loading' => [
        'page' => 'Sayfa taranıyor',
        'scripts' => 'Sitenin betikleri okunuyor',
        'files' => 'robots.txt ve llms.txt kontrol ediliyor',
        'checks' => '15 kontrol yapılıyor',
    ],
    'verdicts' => [
        'ready' => 'Yapay zekâ ajanlarına hazır',
        'almost' => 'Yapay zekâ ajanlarına neredeyse hazır',
        'partly' => 'Yapay zekâ ajanlarına kısmen hazır',
        'not_ready' => 'Yapay zekâ ajanlarına hazır değil',
    ],
    'groups' => [
        'B' => [
            'title' => 'Yapay zekâ sizi buluyor mu?',
            'text' => 'Yapay zekâ modellerinin ve arama botlarının gördükleri',
        ],
        'A' => [
            'title' => 'Ajan sitede ne yapabilir',
            'text' => 'Tarayıcıdaki yapay zekâ ajanları için WebMCP araçları',
        ],
        'D' => [
            'title' => 'Araçlar ne kadar anlaşılır',
            'text' => 'Adlar, açıklamalar, şemalar ve ipuçları',
        ],
        'C' => [
            'title' => 'Ajan için burası güvenli mi?',
            'text' => 'HTTPS, betik sınırları, karışık içerik',
        ],
    ],
    'checks' => [
        'A1' => [
            'title' => 'Ajan bir formu doldurabilir mi?',
            'text' => 'toolname ve tooldescription içeren formlar',
            'fix' => 'Yararlı bir işlem yapan forma (arama, rezervasyon, sipariş) toolname ve tooldescription ekleyin ve her alanı toolparamdescription ile açıklayın.',
            'notes' => [
                'none' => 'Sayfada toolname öznitelikli form yok.',
                'imperative_only' => 'Site araçlarını JavaScript ile kaydediyor, bu yüzden form gerekmiyor.',
                'no_description' => 'toolname olup tooldescription olmayan form sayısı: :count. Ajan ne yaptıklarını bilemez.',
                'found' => 'Yapay zekâ ajanlarına araç olarak sunulan form sayısı: :count.',
            ],
        ],
        'A2' => [
            'title' => 'Site ajana JavaScript ile işlemler sunuyor mu?',
            'text' => 'document.modelContext.registerTool()',
            'fix' => 'Araçları JavaScript ile document.modelContext.registerTool() kullanarak kaydedin. navigator.modelContext, API’nin eski konumudur ve 2026 ortasından beri kullanımdan kalkmıştır.',
            'notes' => [
                'none' => 'Sitenin betiklerinde (:scripts) registerTool() çağrısı bulunamadı. Yalnızca bir kullanıcı işleminden sonra yüklenen kod kontrol edilmez.',
                'declarative_only' => 'Site araçlarını form olarak sunuyor, bu yüzden JavaScript ile kayıt gerekmiyor.',
                'deprecated' => 'Bulunan araç sayısı: :count, ancak kod API’nin eski konumu olan navigator.modelContext’i kullanıyor.',
                'found' => 'JavaScript ile kaydedilen araç sayısı: :count.',
            ],
        ],
        'A3' => [
            'title' => 'Form alanları ajan için anlaşılır mı?',
            'text' => 'Her alanda name ve toolparamdescription',
            'fix' => 'Araç formunun her alanına name ve toolparamdescription verin; kesin türler (email, number, date) ve değerlerin kuralı varsa required veya pattern kullanın.',
            'notes' => [
                'no_forms' => 'Sayfada araç formu yok.',
                'no_fields' => 'Araç formlarında bir ajanın doldurabileceği alan yok.',
                'all_good' => 'Tüm alanlar açıklanmış (:count).',
                'some_missing' => ':count alandan :good tanesi tam olarak açıklanmış.',
                'most_missing' => ':count alandan yalnızca :good tanesi tam olarak açıklanmış.',
            ],
        ],
        'B1' => [
            'title' => 'Yapay zekâ bunun nasıl bir site olduğunu anlıyor mu?',
            'text' => 'Schema.org yapılandırılmış verisi',
            'fix' => 'Sayfaya uygun Schema.org türüyle bir JSON-LD bloğu ekleyin: Organization, LocalBusiness, Product, Article veya FAQPage.',
            'notes' => [
                'json_ld' => 'Bulunan JSON-LD blok sayısı: :count.',
                'invalid_json' => 'Sayfada JSON-LD var, ancak geçerli JSON değil; modeller onu yok sayar.',
                'microdata_only' => 'Yalnızca microdata kullanılıyor; JSON-LD yapay zekâ modelleri için daha kolay okunur.',
                'none' => 'Sayfada yapılandırılmış veri yok.',
            ],
        ],
        'B2' => [
            'title' => 'Yapay zekâ için kısa bir site rehberi var mı?',
            'text' => '/llms.txt dosyası',
            'fix' => '/llms.txt oluşturun: ana sayfalara bağlantılar içeren kısa bir Markdown site özeti (llmstxt.org).',
            'notes' => [
                'found' => 'Dosya erişilebilir.',
                'full_only' => 'Yalnızca /llms-full.txt bulundu; modeller önce /llms.txt arar.',
                'none' => 'Ne /llms.txt ne de /llms-full.txt bulundu.',
            ],
        ],
        'B3' => [
            'title' => 'Meta description sayfayı açıklıyor mu?',
            'text' => '50–160 karakter',
            'fix' => 'Sayfanın ne sunduğunu söyleyen, 50–160 karakter uzunluğunda bir meta description yazın.',
            'notes' => [
                'none' => 'Sayfada meta description yok.',
                'good' => ':length karakter, :min–:max aralığında.',
                'length' => ':length karakter; önerilen :min–:max.',
            ],
        ],
        'B4' => [
            'title' => 'Siteye verilen bağlantı iyi görünüyor mu?',
            'text' => 'Open Graph etiketleri',
            'fix' => 'Eksik Open Graph etiketlerini ekleyin: ajanlar ve sosyal ağlar bir bağlantıyı bunlarla tanımlar.',
            'notes' => [
                'all' => ':total etiketin tamamı mevcut.',
                'none' => 'Sayfada Open Graph etiketi yok.',
                'some' => ':total etiketten :count tanesi var; eksik: :missing.',
            ],
        ],
        'B5' => [
            'title' => 'Site yapay zekâ botlarını içeri alıyor mu?',
            'text' => 'robots.txt kuralları',
            'fix' => 'robots.txt’de bulunmak istediğiniz yapay zekâ tarayıcılarına izin verin veya onları engelleyen kuralları kaldırın.',
            'notes' => [
                'no_robots' => 'robots.txt yok, dolayısıyla hiçbir şey engellenmiyor.',
                'allowed' => 'Yapay zekâ tarayıcılarına izin veriliyor.',
                'all_blocked' => 'Bilinen tüm yapay zekâ tarayıcıları engelleniyor.',
                'some_blocked' => 'Engellenen yapay zekâ tarayıcısı sayısı: :count.',
            ],
        ],
        'C1' => [
            'title' => 'Bağlantı güvenli mi?',
            'text' => 'HTTPS',
            'fix' => 'Siteyi HTTPS’ye taşıyın ve http:// adresini https:// adresine yönlendirin: WebMCP yalnızca güvenli bağlamda çalışır.',
            'notes' => [
                'https' => 'Sayfa HTTPS üzerinden sunuluyor.',
                'http' => 'Sayfa şifrelenmemiş HTTP üzerinden sunuluyor; tarayıcılar orada WebMCP sunmaz.',
            ],
        ],
        'C2' => [
            'title' => 'Sayfa üçüncü taraf betikleri sınırlıyor mu?',
            'text' => 'Content-Security-Policy başlığı',
            'fix' => 'Content-Security-Policy başlığı gönderin: sıkı bir politikayla başlayın ve yalnızca sitenin gerçekten kullandığı kaynaklara izin verin.',
            'notes' => [
                'none' => 'Content-Security-Policy başlığı yok.',
                'unsafe_eval' => 'Politika \'unsafe-eval\' kullanımına izin veriyor.',
                'found' => 'Bir politika ayarlanmış.',
            ],
        ],
        'C3' => [
            'title' => 'Her şey HTTPS ile mi yükleniyor?',
            'text' => 'http:// kaynak yok',
            'fix' => 'Tüm betikleri, stilleri, görselleri ve çerçeveleri https:// üzerinden yükleyin.',
            'notes' => [
                'not_https' => 'Sayfa HTTPS üzerinden sunulmuyor.',
                'none' => 'Tüm kaynaklar HTTPS üzerinden yükleniyor.',
                'found' => 'Şifrelenmemiş HTTP ile yüklenen kaynak sayısı: :count.',
            ],
        ],
        'D1' => [
            'title' => 'Adlar aracın ne yaptığını söylüyor mu?',
            'text' => 'Spesifikasyona uygun adlar',
            'fix' => 'a–z, 0–9, "_", "-" ve "." karakterlerinden oluşan, 3–128 karakterlik ve bir eylemle başlayan adlar kullanın: search_products, book_table.',
            'notes' => [
                'no_tools' => 'Kontrol edilecek araç yok.',
                'unreadable' => 'Araç adları çalışma sırasında oluşturuluyor ve kod çalıştırılmadan okunamıyor.',
                'all_good' => 'Tüm adlar iyi (:count).',
                'bad_names' => 'İyi adlar: :count adın :good tanesi.',
            ],
        ],
        'D2' => [
            'title' => 'Açıklamalar yeterince ayrıntılı mı?',
            'text' => 'En az 20 karakter',
            'fix' => 'Her aracın ne yaptığını ve ne zaman kullanılacağını bir iki cümleyle açıklayın: model aracı açıklamasına göre seçer.',
            'notes' => [
                'no_tools' => 'Kontrol edilecek araç yok.',
                'unreadable' => 'Araç açıklamaları çalışma sırasında oluşturuluyor ve kod çalıştırılmadan okunamıyor.',
                'all_good' => 'Tüm açıklamalar yeterince uzun (:count).',
                'short' => 'Yeterince uzun açıklamalar: :count açıklamanın :good tanesi.',
            ],
        ],
        'D3' => [
            'title' => 'Ajan hangi parametreleri vereceğini biliyor mu?',
            'text' => 'inputSchema ve alan açıklamaları',
            'fix' => 'Her JavaScript aracına türü ve açıklaması olan özelliklerle bir inputSchema verin ve her form alanını toolparamdescription ile açıklayın.',
            'notes' => [
                'no_tools' => 'Kontrol edilecek araç yok.',
                'unreadable' => 'Araç şemaları çalışma sırasında oluşturuluyor ve kod çalıştırılmadan okunamıyor.',
                'all_good' => 'Tüm araçlar parametrelerini açıklıyor (:count).',
                'incomplete' => ':count araçtan :good tanesi parametrelerini tam olarak açıklıyor.',
            ],
        ],
        'D4' => [
            'title' => 'Ajan hangi işlemlerin veri değiştirdiğini biliyor mu?',
            'text' => 'readOnlyHint ipucu',
            'fix' => 'JavaScript araçlarına ek açıklamalar ekleyin; yalnızca veri okuyan araçlar için en azından readOnlyHint: true.',
            'notes' => [
                'no_tools' => 'Kontrol edilecek araç yok.',
                'declarative_only' => 'Ek açıklamalar yalnızca JavaScript araçları için geçerlidir.',
                'all_good' => 'Tüm araçların ek açıklaması var (:count).',
                'missing' => ':count araçtan :good tanesinin ek açıklaması var.',
            ],
        ],
    ],
];
