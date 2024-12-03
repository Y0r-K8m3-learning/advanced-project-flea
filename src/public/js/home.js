$(document).ready(function () {
    $('#recommend, #mylist').on('click', function (e) {
        e.preventDefault(); // デフォルトのリンク動作を防止

        const url = $(this).find('a').attr('href');

        $.ajax({
            url: url,
            method: "GET",
            success: function (response) {
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
                } else {
                    console.warn('データ形式が正しくありません。', response);
                }
            },
            error: function () {
                console.error('検索に失敗しました');
            }
        });
    });
});
