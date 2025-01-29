$(document).ready(function () {
    const $searchInput = $('#search-input');
    const $itemCards = $('.item-card');
    // 入力イベントを監視
    $searchInput.on('input', function () {
        const query = $(this).val().toLowerCase().trim();
        console.log(query);
                    
        // 各アイテムをループして表示/非表示を切り替え
        $itemCards.each(function() {
            const itemName = $(this).data('name');
            
            if (itemName.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // 該当アイテムがない場合のメッセージ表示
        const visibleItems = $itemCards.filter(':visible').length;
        const $itemGrid = $('#item-grid');

        // 既にメッセージが表示されている場合は削除
        $itemGrid.find('.no-results').remove();

        if (visibleItems === 0) {
            $itemGrid.append('<p class="no-results text-center mt-4">該当する商品がありません。</p>');
        }
    });


    $('#recommend, #mylist').on('click', function (e) {

        e.preventDefault(); // デフォルトのリンク動作を防止

        const url = $(this).find('a').attr('href');

        $('#recommend a, #mylist a').removeClass('active-link');
        // クリックしたリンクに 'active-link' を追加
        $(this).find('a').addClass('active-link');
        $.ajax({
            url: url,
            method: "GET",
            success: function (response) {
                if (response.redirect) {

            window.location.href = response.redirect; // ログイン画面にリダイレクト
        }

                // response.items が存在するか確認
                const $itemGrid = $('.container .row');
                
                    $itemGrid.empty(); // 現在のアイテムをクリア
                    if (response.items && Array.isArray(response.items)) {
                    // 新しいデータをレンダリング
                    response.items.forEach(item => {
                        $itemGrid.append(`
                            <div class="col-4 text-center mb-4 col-md-3">
                                <a href="/items/${item.id}" class="text-decoration-none">
                                    <img src="${item.image_url}" class="img-fluid rounded border" alt="${item.name}">
                                    <p class="mt-2">${item.name}</p>
                                </a>
                            </div>
                        `);
                    });
                    } 
            },
            error: function () {
                  console.log(response);
                console.error('検索に失敗しました');
            }
        });
    });
});
