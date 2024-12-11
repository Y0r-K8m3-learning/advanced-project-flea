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
<script src="{{ asset('js/item_create.js') }}"></script>
@endsection

<x-app-layout>
    <div class="container mt-5">
        <h4 class="mb-4">支払方法変更</h4>
        <form action="{{ route('payment.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <input type="text" name="item_id" value="{{$item_id}}" class="form-check-input" hidden>

                <label class="form-check">
                    <input type="radio" name="payment_method" value="card" class="form-check-input" checked>
                    <span class="form-check-label">クレジットカード </span>
                </label>
                <label class="form-check">
                    <input type="radio" name="payment_method" value="customer_balance" class="form-check-input" checked>
                    <span class="form-check-label">銀行振込</span>
                </label>
                <label class="form-check">
                    <input type="radio" name="payment_method" value="konbini" class="form-check-input" checked>
                    <span class="form-check-label">コンビニ</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary">変更を保存</button>
        </form>
    </div>
</x-app-layout>