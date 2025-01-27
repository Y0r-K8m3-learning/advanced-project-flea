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
    <div class="mt-5 d-flex">
        <img src="{{ asset('images/default_icon.png') }}" class="rounded-circle border bg-orange" alt="" width="100" height="100">
        <span>ダミーユーザ</span>
    </div>

    <!-- 上段: おすすめとマイリスト -->
    <div class="d-flex mt-3">
        <div id="recommend" class="section-title  ms-5">
            <button>出品した商品</button>
        </div>
        <div id="mylist" class="section-title  ms-5"><button>購入した商品</button></div>
    </div>

    <!-- 水平線 -->
    <div class="border-bottom border-dark mb-4"></div>



    <!-- 商品一覧表示エリア -->
    <div class="row mt-4" id="item-grid">
        <!-- 初期表示で出品商品を表示 -->
        @foreach ($listings as $listing)
        <div class="col-4 text-center mb-4">
            <img src="{{ asset($listing['image']) }}" class="img-fluid rounded" alt="{{ $listing['name'] }}">
        </div>
        @endforeach
    </div>



</x-app-layout>