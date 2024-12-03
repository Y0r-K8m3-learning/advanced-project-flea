<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('css')
    @yield('js')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- Header (固定) -->
    <div class="header" style="position: fixed; top: 0; width: 100%; z-index: 1000; background-color: black; color: white; display: flex; justify-content: space-between; align-items: center; padding: 10px;">
        <div>

            <span class="material-symbols-outlined">
                <img src="{{ asset('icons/logo.svg') }}" alt="Log Icon" style="height: 24px;;"> <!-- アイコンを追加 -->

            </span>
        </div>
        @if (!in_array(request()->route()->getName(), ['login', 'register']))
        <div class="w-50">
            <x-my-text-input
                class="search-text border border-gray-300 p-2"
                id=""
                type=""
                name=""
                :value="old('email')"
                autofocus
                autocomplete="username"
                placeholder="なにをお探しですか?" />
        </div>
        @endif
        <div class="flex items-center">

            @if (Auth::check())
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    <div class="nav-link" style="color: white;">
                        {{ __('Log Out') }}
                    </div>
                </x-dropdown-link>
            </form>
            <a class="nav-link" href="/mypage" style="color: white;">Mypage</a>
            @else
            <a class="nav-link" href="/register" style="color: white;">Registration</a>
            <a class="nav-link" href="/login" style="color: white;">Login</a>
            <a class="btn btn-light border text-black" href="/item/create">出品</a>

            @endif
        </div>
    </div>

    <!-- コンテンツ  -->
    <div class="content-container" style="margin-top: 60px; padding: 20px; height: calc(100vh - 80px); overflow-y: auto;">
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>

    </script>
</body>



</html>

</html>