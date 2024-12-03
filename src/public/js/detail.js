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
});
