    $(document).ready(function() {
        // 「おすすめ」をクリックしたときの処理
        $('#recommend').on('click', function() {
            // 「おすすめ」を赤文字にして、他の項目を元の色に戻す
            $(this).addClass('active');
            $('#mylist').removeClass('active');

            // Ajaxリクエストで検索結果を取得
            $.ajax({
                url: '/items/recommend', // ルートURL
                method: 'GET',
                success: function(items) {
                    // 結果を表示するエリア
                    const $itemGrid = $('#item-grid');
                    $itemGrid.empty(); // 既存のアイテムをクリア

                    // 取得した商品アイテムを追加
                    items.forEach(function(item) {
                        $itemGrid.append(`
                            <div class="col-4 text-center mb-4">
                                <img src="${item.image}" class="img-fluid rounded" alt="${item.name}">
                                <p>${item.name}</p>
                            </div>
                        `);
                    });
                },
                error: function() {
                    console.error('データの取得に失敗しました');
                }
            });
        });
 
          $('#mylist').on('click', function() {
            // 「おすすめ」を赤文字にして、他の項目を元の色に戻す
            $(this).addClass('active');
            $('#recommend').removeClass('active');

            // Ajaxリクエストで検索結果を取得
            $.ajax({
                url: '/items/recommend', // ルートURL
                method: 'GET',
                success: function(items) {
                    // 結果を表示するエリア
                    const $itemGrid = $('#item-grid');
                    $itemGrid.empty(); // 既存のアイテムをクリア

                    // 取得した商品アイテムを追加
                    items.forEach(function(item) {
                        $itemGrid.append(`
                            <div class="col-4 text-center mb-4">
                                <img src="${item.image}" class="img-fluid rounded" alt="${item.name}">
                                <p>${item.name}</p>
                            </div>
                        `);
                    });
                },
                error: function() {
                    console.error('データの取得に失敗しました');
                }
            });
        });

    });