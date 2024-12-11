@section('css')
<link rel="stylesheet" href="{{ asset('css/card.css') }}">
<link rel="stylesheet" href="{{ asset('css/itemcreate.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endsection

@section('js')
<script>
    window.csrfToken = "{{ csrf_token() }}";
    window.searchUrl = "{{ route('restaurants.index') }}";
</script>
@endsection

<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <!-- 左側: 入力内容 -->
            <div class="col-md-6">

                <!-- 商品情報 -->
                <div class="border mb-4">
                    <div class="card-body">
                        <img src="{{ asset('images/dummy_product.png') }}" class="img-fluid mb-3" alt="ダミー商品">
                        <h5>{{$item['name']}}</h5>
                        <p>価格: ¥{{$item['price']}}</p>
                    </div>
                </div>

                <!-- 支払方法 -->
                <div class=" mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">支払方法</h5>
                        <a href="{{ route('payment.edit', ['item_id' => $item['item_id']]) }}" class="text-primary">変更する</a>
                    </div>
                </div>

                <!-- 配送先 -->
                <div class="">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">配送先</h5>
                        <a href="{{ route('address.edit') }}" class="text-primary">変更する</a>
                    </div>

                </div>
            </div>

            <!-- 右側: 確認内容 -->
            <div class="col-md-6 border">
                <h4 class="mb-4">購入内容の確認</h4>
                <div class=" mb-4">
                    <div class="card-body">
                        <p>購入代金 <span class="ms-4">¥{{$item['price']}}</span></p>
                    </div>
                </div>

                <div class=" mb-4">
                    <div class="card-body">
                        <p>支払い金額 <span class="ms-4">¥{{$item['price']}}</span></p>
                    </div>
                </div>

                <div class=" mb-4">
                    <div class="card-body">
                        <p>支払方法 <span class="ms-4">{{$paymethod['name']}}</span></p>

                    </div>
                </div>

                <div class=" mb-4">
                    <div class="card-body">

                    </div>
                </div>
                <!-- 支払情報 -->
                <div class="card mb-4" hidden>
                    <div class="card-body">
                        <h5>支払情報</h5>
                        <div id="card-element" class="mt-3"></div>
                        <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                    </div>
                </div>

            </div>
            <!-- 購入ボタン -->
            <form action="{{ route('purchase.process') }}" method="POST">
                @csrf
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-danger w-50">購入する</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>