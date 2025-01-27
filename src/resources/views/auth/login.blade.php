@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,300,1,200" />
@endsection

<x-app-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-5" :status="session('status')" />
    <div class="flex items-center justify-center mt-5 ">
        <div class="w-full max-w-md">
            <div class="rounded-3 border-bottom  border-end border-white">

                <div class="text-xl font-bold p-4 rounded-t-lg rounded-top text-center">
                    {{ __('Log in') }}
                </div>
                <div class="bg-white p-6 rounded-b-lg border border-white">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-4">
                            <div class="mb-4">
                                <x-input-label for="email" class="mr-2 mb-3" /><strong>メールアドレス</strong>
                                <x-my-text-input
                                    class="border border-gray-300 p-2 w-full"
                                    id="email"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    autofocus
                                    autocomplete="username"
                                    placeholder="" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 pl-9 ms-4" />
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <x-input-label for="password" class="mr-2" /><strong>パスワード</strong>
                            <x-my-text-input
                                class="border border-gray-300 p-2 w-full"
                                id="password"
                                type="password"
                                name="password"
                                autocomplete="current-password"
                                placeholder="" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 pl-9 ms-4" />
                        </div>

                        <!-- Log in Button -->
                        <div class="w-full flex items-center justify-end">
                            @if (session('error'))
                            <div class="alert-danger pull-left fs-6 w-75">
                                {{ session('error') }}
                            </div>
                            @endif

                            <button class="w-full py-2 px-4 bg-red-500 text-white rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                {{ __('Log in') }}
                            </button>
                        </div>
                        <div class="mt-3 flex items-center justify-center">
                            <a href="/register" class="text-blue-500">会員登録はこちら</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>