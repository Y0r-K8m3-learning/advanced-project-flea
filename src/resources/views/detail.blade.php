@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=chat_bubble" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<style>
    .comment-section {
        display: none;
        /* 初期状態で非表示 */
        background-color: transparent;
        /* 背景色を透明に設定 */
        padding: 10px;
    }
</style>
@endsection

@section('js')
<script src="{{ asset('js/detail.js') }}"></script>
@endsection

<x-app-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container">
        <div class="row">
            <!-- 左側: 商品画像 -->
            <div class="col-md-6 fw-bold">
                <div class="mb-4 mt-3">
                    <img src="{{ asset($item['image']) }}" class="img-fluid rounded border" alt="{{ $item['name'] }}">
                </div>
            </div>

            <!-- 右側: 商品情報 -->
            <div class="col-md-6 product-details">
                <div class="rounded shadow p-4">
                    <!-- 商品名 -->
                    <h2 class="mb-3">{{ $item['name'] }}</h2>
                    <p class="mb-3">ブランド名：{{ $item['brand'] ?? 'N/A' }}</p>
                    <h4 class="mb-3">価格：¥{{ number_format($item['price']) }}</h4>

                    <!-- 星マーク・吹き出しマーク -->
                    <div class="d-flex align-items-center mb-4">
                        <svg class="star-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <polygon
                                fill="white"
                                stroke="black"
                                stroke-width="2"
                                points="12,2 15,8.5 22,9.3 17,14 18.5,21 12,17.5 5.5,21 7,14 2,9.3 9,8.5" />
                        </svg>
                        <span class="material-symbols-outlined ms-3" style="cursor: pointer;" title="コメント">
                            chat_bubble
                        </span>
                    </div>

                    <!-- コメント欄 -->
                    <div class="comment-section" id="comment-section">
                        <div class="user-comment">
                            <div style="display: flex; align-items: center;">
                                <img src="https://via.placeholder.com/40" alt="User Icon">
                                <span class="user-name">XXXXX</span>
                            </div>
                            <p>XXXXX</p>
                        </div>
                        <div class="user-comment">
                            <div style="display: flex; align-items: center;">
                                <img src="https://via.placeholder.com/40" alt="User Icon">
                                <span class="user-name">XXXXX</span>
                            </div>
                            <p>XXXXX</p>
                        </div>
                        <div class="comment-input">
                            <textarea placeholder="コメントを入力..."></textarea>
                            <button>コメントを送信</button>
                        </div>
                    </div>

                    <!-- 購入ボタン -->
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary w-100 shadow rounded" id="purchase-button">
                            購入する
                        </button>
                    </div>

                    <!-- 「商品説明」以下の内容 -->
                    <h5 class="mb-3">商品説明</h5>
                    <p class="mb-4">{{ $item['description'] ?? '説明がありません。' }}</p>
                    <h5 class="mb-3">商品の情報</h5>
                    <p class="mb-3">カテゴリー：{{ $item['category'] ?? '未分類' }}</p>
                    <p>商品の状態：{{ $item['condition'] ?? '不明' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>