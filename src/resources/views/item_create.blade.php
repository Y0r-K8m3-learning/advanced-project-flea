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
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container mt-5">
        <h1 class="mb-4">商品出品ページ</h1>
        <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- 商品画像 -->
            <div class="mb-4">
                <label for="product-image" class="form-label">商品画像</label>
                <input type="file" name="image" id="product-image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- カテゴリー（複数選択可能なプルダウン） -->
            <div class="mb-4">
                <label for="categories" class="form-label">カテゴリー</label>
                <select name="categories[]" id="categories" class="form-select @error('categories') is-invalid @enderror" multiple>
                    <option value="electronics">家電</option>
                    <option value="fashion">ファッション</option>
                    <option value="books">本</option>
                    <option value="sports">スポーツ</option>
                </select>
                @error('categories')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 商品の状態（プルダウン形式） -->
            <div class="mb-4">
                <label for="condition" class="form-label">商品の状態</label>
                <select name="condition" id="condition" class="form-select @error('condition') is-invalid @enderror">
                    <option value="">状態を選択してください</option>
                    <option value="new">新品</option>
                    <option value="used">中古</option>
                </select>
                @error('condition')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 商品名 -->
            <div class="mb-4">
                <label for="product-name" class="form-label">商品名</label>
                <input type="text" name="name" id="product-name" class="form-control @error('name') is-invalid @enderror" placeholder="商品名を入力">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 商品の説明 -->
            <div class="mb-4">
                <label for="product-description" class="form-label">商品の説明</label>
                <textarea name="description" id="product-description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="商品の説明を入力"></textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 販売価格 -->
            <div class="mb-4">
                <label for="product-price" class="form-label">販売価格</label>
                <input type="number" name="price" id="product-price" class="form-control @error('price') is-invalid @enderror" placeholder="価格を入力">
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 出品するボタン -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">出品する</button>
            </div>
        </form>
    </div>
</x-app-layout>