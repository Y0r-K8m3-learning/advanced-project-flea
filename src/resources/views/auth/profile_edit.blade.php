@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,300,1,200" />
@endsection

<x-app-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container mt-5">
        <h1 class="mb-4">プロフィール設定</h1>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- アイコン選択 -->
            <div class="mb-4">
                <label for="icon" class="form-label">アイコン</label>
                <input type="file" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror">
                @error('icon')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- ユーザ名 -->
            <div class="mb-4">
                <label for="username" class="form-label">ユーザ名</label>
                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" placeholder="ユーザ名を入力">
                @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 郵便番号 -->
            <div class="mb-4">
                <label for="postcode" class="form-label">郵便番号</label>
                <input type="text" name="postcode" id="postcode" class="form-control @error('postcode') is-invalid @enderror" value="{{ old('postcode', $user->postcode) }}" placeholder="例: 123-4567">
                @error('postcode')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 住所 -->
            <div class="mb-4">
                <label for="address" class="form-label">住所</label>
                <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}" placeholder="住所を入力">
                @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 建物名 -->
            <div class="mb-4">
                <label for="building" class="form-label">建物名</label>
                <input type="text" name="building" id="building" class="form-control @error('building') is-invalid @enderror" value="{{ old('building', $user->building) }}" placeholder="建物名を入力">
                @error('building')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- 更新ボタン -->
            <div class="d-grid">
                <button type="submit" class="btn bg-red-500">更新</button>
            </div>
        </form>
    </div>
</x-app-layout>