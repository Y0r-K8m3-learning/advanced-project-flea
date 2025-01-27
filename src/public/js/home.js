$(document).ready(function () {
    $('#recommend, #mylist').on('click', function (e) {
        e.preventDefault(); // デフォルトのリンク動作を防止

        const url = $(this).find('a').attr('href');
                console.log(url);

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
