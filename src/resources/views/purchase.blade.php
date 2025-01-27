@section('css')
<link rel="stylesheet" href="{{ asset('css/card.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endsection

@section('js')
<script src="https://js.stripe.com/v3/"></script>
<script>
    window.csrfToken = "{{ csrf_token() }}";
    window.stripePublicKey = "{{ config('stripe.stripe_public_key') }}";
    window.purchaseInitiateUrl = "{{ route('purchase.initiate') }}";
    window.purchaseConfirmUrl = "{{ route('purchase.confirm') }}";
    window.itemId = "{{ $item['item_id'] }}";
    window.selectedPayMethod = "{{ $paymethod['value'] }}"; // 'card', 'konbini', 'bank_transfer'
</script>
<script src="{{ asset('js/purchase.js') }}"></script>
@endsection

<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <!-- 左側: 入力内容 -->
            <div class="col-md-6">
                <div class="mb-4">
                    <div class="card-body">
                        <img src="{{ asset($item['image']) }}" class="img-fluid mb-3" alt="{{ $item['name'] }}">

                    </div>
                    <div class="col-4">

                        <h5>{{ $item['name']  }}</h5>
                        <p>価格: ¥{{ number_format($item['price']) }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">支払方法</h5>
                        <!-- 支払い方法変更リンク省略可能 -->
                        <a href="{{ route('payment.edit', ['item_id' => $item['item_id']]) }}" class="text-primary">変更する</a>
                    </div>
                </div>

                <div class="">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">配送先</h5>
                        <!-- 配送先変更リンクなど -->
                        <a href="{{ route('address.edit') }}" class="text-primary">変更する</a>
                    </div>
                </div>
            </div>

            <!-- 右側: 確認内容 -->
            <div class="col-md-6 border">
                <h4 class="mb-4">購入内容の確認</h4>
                <div class="mb-4">
                    <div class="card-body">
                        <p>購入代金 <span class="ms-4">¥{{ number_format($item['price']) }}</span></p>
                    </div>
                    <div class="card-body">
                        <p>支払い金額 <span class="ms-4">¥{{ number_format($item['price']) }}</span></p>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="card-body">
                        <p>支払方法 <span class="ms-4">{{ $paymethod['name'] }}</span></p>
                    </div>
                </div>
                @if($paymethod['value'] === 'card')
                <div class="card mb-4">
                    @csrf
                    <div class="card-body">
                        <h5>支払情報</h5>
                        <div>テスト: 4242 4242 4242 4242</div>
                        <div>
                            <label for="card_number">カード番号</label>
                            <div id="card-number" class="form-control"></div>
                        </div>

                        <div>
                            <label for="card_expiry">有効期限</label>
                            <div id="card-expiry" class="form-control"></div>
                        </div>

                        <div>
                            <label for="card-cvc">セキュリティコード</label>
                            <div id="card-cvc" class="form-control"></div>
                        </div>

                        <div id="card-errors" class="text-danger"></div>

                    </div>
                </div>
                @endif

                <!-- 購入ボタン -->
                <form id="purchase-form">
                    @csrf
                    <button type="submit" class="btn btn-danger w-50">購入する</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>