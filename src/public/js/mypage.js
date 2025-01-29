document.addEventListener('DOMContentLoaded', function () {
    const showListingsButton = document.getElementById('show-listings');
    const showPurchasesButton = document.getElementById('show-purchases');
    const itemGrid = document.getElementById('item-grid');
    const purchasedItemGrid = document.getElementById('purchased-item-grid');

    function updateAriaPressed(selectedButton, deselectedButton) {
        selectedButton.setAttribute('aria-pressed', 'true');
        deselectedButton.setAttribute('aria-pressed', 'false');
    }

    function showSection(sectionToShow, sectionToHide, buttonToSelect, buttonToDeselect) {
        // ボタンの選択状態を切り替え
        buttonToSelect.classList.add('selected');
        buttonToDeselect.classList.remove('selected');

        // ARIA属性を更新
        updateAriaPressed(buttonToSelect, buttonToDeselect);

        // 商品一覧の表示・非表示を切り替え
        sectionToShow.style.display = 'flex';
        sectionToHide.style.display = 'none';
    }

    // 初期表示設定
    itemGrid.style.display = 'flex';
    purchasedItemGrid.style.display = 'none';

    showListingsButton.addEventListener('click', function () {
        showSection(itemGrid, purchasedItemGrid, showListingsButton, showPurchasesButton);
    });

    showPurchasesButton.addEventListener('click', function () {
        showSection(purchasedItemGrid, itemGrid, showPurchasesButton, showListingsButton);
    });
});
