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
                    <img src="{{ asset($item['image_url']) }}" class="img-fluid rounded border" alt="{{ $item['name'] }}">
                </div>
            </div>
            <!-- 右側: 商品情報 -->
            <div class="col-md-6 product-details">
                <div class="rounded shadow p-4">
                    <!-- 商品名 -->
                    <h2 class="mb-3">{{ $item['name'] }}</h2>
                    <p class="mb-3">ブランド名：{{ $item['brand'] ?? '' }}</p>
                    <h4 class="mb-3">価格：¥{{ number_format($item['price']) }}</h4>

                    <!-- 星マーク・吹き出しマーク -->
                    <div class="d-flex align-items-center mb-4">
                        <svg class="star-icon" data-item-id=" {{ $item->id }}" viewBox="0 0 24 24" style="cursor: pointer;">
                            <polygon
                                fill="{{ $item->is_favorite ? 'yellow' : 'white' }}"
                                stroke="black"
                                stroke-width="2"
                                points="12,2 15,8.5 22,9.3 17,14 18.5,21 12,17.5 5.5,21 7,14 2,9.3 9,8.5" />
                        </svg>
                        <span class="material-symbols-outlined ms-3" style="cursor: pointer;" title="コメント">
                            chat_bubble
                        </span>
                    </div>

                    <div class="comment-section" id="comment-section">
                        @forelse ($comments as $comment)
                        <div class="user-comment {{ ($comment->user_id == optional(Auth::user())->id) ? 'own-comment' : '' }}">
                            <div style="display: flex; align-items: center;">
                                <img src="{{ $comment->user->profile_image_url ?? 'https://via.placeholder.com/40' }}" alt="User Icon">
                                <span class="user-name">{{ $comment->user->name }}</span>
                            </div>
                            <p>{{ $comment->comment }}</p>
                        </div>
                        @empty
                        <p>コメントはまだありません。</p>
                        @endforelse
                        <!-- コメント入力欄 -->


                        @auth
                        <div class="comment-input">
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                                <textarea name="comment" placeholder="コメントを入力..." required></textarea>
                                <button type="submit">コメントを送信</button>
                            </form>
                        </div>
                        @endauth
                    </div>
                    <!-- 購入ボタン -->
                    <div class="mb-4">
                        <a href="{{ route('purchase.show', ['item' => $item['id']]) }}" class="btn btn-danger w-100 shadow rounded" id="purchase-button">
                            購入する
                        </a>
                    </div>

                    <!-- 「商品説明」以下の内容 -->
                    <h5 class="mb-3">商品説明</h5>
                    <p class="mb-4">{{ $item['description'] ?? '説明がありません。' }}</p>
                    <h5 class="mb-3">商品の情報</h5>
                    <p class="mb-3">
                        カテゴリー：
                        <span>
                            @foreach($item->categories as $category)
                            {{ $category['name'] ?? '未分類' }}
                            @endforeach
                        </span>

                    </p>
                    <p>商品の状態：{{ $item->condition->name ?? '不明' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>