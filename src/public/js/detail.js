$(document).ready(function () {
    // コメントマークと対象セクション
    const commentToggle = $('.material-symbols-outlined[title="コメント"]');
    const commentSection = $('#comment-section');
    const belowDescription = $('#purchase-button').parent().nextAll();
    const purchaseButton = $('#purchase-button').parent();

    // コメントマークのクリックイベント
    commentToggle.on('click', function () {
        // コメント欄の表示・非表示を切り替え
        commentSection.toggle();
        // 「商品説明」以下と購入ボタンの表示・非表示を切り替え
        if (commentSection.is(':visible')) {
            belowDescription.hide(); // 「商品説明」以下を非表示
            purchaseButton.hide();   // 購入ボタンを非表示
        } else {
            belowDescription.show(); // 「商品説明」以下を表示
            purchaseButton.show();   // 購入ボタンを表示
        }
    });

    $('.star-icon').on('click', function () {
        console.log('1');
        const $this = $(this);
        const itemId = $this.data('item-id'); // アイテム ID を取得

        // Ajax リクエストを送信
        $.ajax({
            url: '/favorites/toggle', // ルートURL
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF トークン
                item_id: itemId,
            },
            success: function (response) {
                console.log('OK');
                // お気に入り状態に応じて色を変更
                if (response.is_favorite) {
                    $this.find('polygon').attr('fill', 'yellow');
                } else {
                    $this.find('polygon').attr('fill', 'white');
                }
            },
            error: function () {
                alert('お気に入りの処理に失敗しました。');
            }
        });
    });
});
