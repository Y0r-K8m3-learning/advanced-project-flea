@section('css')
<link rel="stylesheet" href="{{ asset('css/card.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endsection

@section('js')
<script>
    window.csrfToken = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/home.js') }}"></script>
@endsection

<x-app-layout>
    <!-- 初期表示 -->
    <div class="d-flex mt-3">
        <div id="recommend" class="section-title ms-5">
            <a href="{{ route('items.search', ['recommend' => true]) }}" class="section-title ms-5">おすすめ</a>
        </div>
        <div id="mylist" class="section-title ms-5">
            <a href="{{ route('items.search', ['mylist' => true]) }}" class="section-title ms-5">マイリスト</a>
        </div>
    </div>

    <!-- 水平線 -->
    <div class="border-bottom border-dark mb-4"></div>

    <!-- 商品画像のグリッド -->
    <div class="container">
        <div class="row" id="item-grid">
            @foreach($items as $item)
            <div class="col-4 text-center mb-4 col-md-3">
                <a href="{{ route('items.detail', ['id' => $item->id]) }}" class="text-decoration-none">
                    <img src="{{ asset($item->image_url) }}" class="img-fluid rounded border" alt="{{ $item->name }}">
                    <p class="mt-2">{{ $item->name }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>


</x-app-layout>