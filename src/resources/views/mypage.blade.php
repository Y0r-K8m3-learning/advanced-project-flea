@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endsection

@section('js')
<script src="{{ asset('js/mypage.js') }}"></script>
@endsection

<x-app-layout>
    <x-auth-session-status :status="session('status')" />

    <!-- ユーザ情報 -->
    <div class="d-flex align-items-center mt-5 w-100">
        <img src="{{ $userDetail && $userDetail->image_id ? Storage::url($userDetail->image_id) : asset('images/default_icon.png') }}" class="rounded-circle border bg-orange me-3" alt="ユーザアイコン" width="100" height="100">
        <div class="d-flex align-items-center  w-100">
            <span class=" d-block">{{ $user->name }}</span>
            <!-- プロフィール編集ボタン -->
            <a href="{{ route('profile.edit') }}" class="ms-5 btn btn-outline-danger custom-edit-button mt-2">プロフィールを編集</a>
        </div>
    </div>

    <!-- 上段: 出品商品と購入商品 -->
    <div class="d-flex mt-3">
        <div id="listing-section" class="section-title ms-5">
            <button id="show-listings" class="btn item selected">出品した商品</button>
        </div>
        <div id="purchase-section" class="section-title ms-5">
            <button id="show-purchases" class="btn item">購入した商品</button>
        </div>
    </div>

    <!-- 水平線 -->
    <div class="border-bottom border-dark mb-4"></div>

    <!-- 出品商品表示エリア -->
    <div class="row mt-4" id="item-grid">
        @foreach ($listings as $listing)
        <div class="col-md-4 text-center mb-4">
            <img src="{{ asset($listing->image_url) }}" class="img-fluid rounded" alt="{{ $listing->name }}">
            <p>{{ $listing->name }}</p>
            <p>価格: ¥{{ number_format($listing->price) }}</p>
        </div>
        @endforeach
    </div>

    <!-- 購入商品表示エリア -->
    <div class="row mt-4" id="purchased-item-grid" style="display: none;">
        @foreach ($purchasedItems as $item)
        <div class="col-md-4 text-center mb-4">
            <img src="{{ asset($item->image_url) }}" class="img-fluid rounded" alt="{{ $item->name }}">
            <p>{{ $item->name }}</p>
            <p>価格: ¥{{ number_format($item->price) }}</p>
        </div>
        @endforeach
    </div>
</x-app-layout>