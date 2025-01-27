@section('css')
<link rel="stylesheet" href="{{ asset('css/item_create.css') }}">
@endsection
@section('js')
<script src="{{ asset('js/item_create.js') }}"></script>
@endsection

<x-app-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container mt-5">
        <h1 class="mb-4">商品出品</h1>
        <!-- ポップアップメッセージ -->
        @if(session('success'))
        <div id="success-popup" class="alert alert-success" role="alert" style="display: none;">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- 商品画像 -->
            <div class="mb-4">
                <label for="product-image" class="form-label d-block">商品画像</label>
                <div class="image-upload-box border border-secondary rounded d-flex align-items-center justify-content-center position-relative" style="height: 200px; width: 100%; cursor: pointer;">
                    <input type="file" name="image" id="product-image" class="form-control d-none" accept="image/*">
                    <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('product-image').click()">画像を選択</button>
                    <!-- 画像プレビュー用のimgタグを追加 -->
                    <img id="image-preview" src="#" alt="画像プレビュー" class="img-fluid position-absolute top-0 left-0 w-100 h-100" style="object-fit: contain; display: none;">
                </div>
                @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div>商品詳細</div>
            <hr>
            <!-- カテゴリー（複数チェックボックス） -->
            <div class="mt-4 mb-4">
                <label for="categories" class="form-label">カテゴリー</label>
                <div id="categories">
                    @foreach($categories as $category)
                    <div class="form-check">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="category-{{ $category->id }}" class="form-check-input">
                        <label for="category-{{ $category->id }}" class="form-check-label">{{ $category->name }}</label>
                    </div>
                    @endforeach
                </div>
                @error('categories')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- 商品の状態（プルダウン形式） -->
            <div class="mb-4">
                <label for="condition" class="form-label">商品の状態</label>
                <select name="condition" id="condition" class="form-select @error('condition') is-invalid @enderror">
                    <option value="">状態を選択してください</option>
                    @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                    @endforeach
                </select>
                @error('condition')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- 商品名 -->
            <div class="mb-4">
                <label for="product-name" class="form-label">商品名</label>
                <input type="text" name="name" id="product-name" class="form-control @error('name') is-invalid @enderror" placeholder="商品名を入力">
                @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- 商品名 -->
            <div class="mb-4">
                <label for="brand-name" class="form-label">ブランド名</label>
                <input type="text" name="brand" id="brand-name" class="form-control @error('name') is-invalid @enderror" placeholder="ブランドを入力">
                @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>


            <!-- 商品の説明 -->
            <div class="mb-4">
                <label for="product-description" class="form-label">商品の説明</label>
                <textarea name="description" id="product-description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="商品の説明を入力"></textarea>
                @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- 販売価格 -->
            <div class="mb-4">
                <label for="product-price" class="form-label">販売価格</label>
                <input type="number" name="price" id="product-price" class="form-control @error('price') is-invalid @enderror" placeholder="価格を入力">
                @error('price')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- 出品するボタン -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">出品する</button>
            </div>
        </form>
    </div>
</x-app-layout>