<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- 別のbladeファイルで定義されたjavascriptを呼び込む --}}
    @yield('javascript')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/layout.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @if(!Auth::check() && (!isset($authgroup) || !Auth::guard($authgroup)->check()))
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    @isset($authgroup)
                                    <a class="nav-link" href="{{ url("login/$authgroup") }}">{{ __('Login') }}</a>
                                    @else
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    @endisset
                                </li>
                            @endif

                            @if (Route::has('register'))
                            @isset($authgroup)
                            @if (Route::has("$authgroup-register"))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route("$authgroup-register") }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            @else
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            @endisset
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @isset($authgroup)
                                    {{ Auth::guard($authgroup)->user()->name }}
                                    @else
                                    {{ Auth::user()->name }}
                                    @endisset
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="btn btn-link" href="{{ route('contact.form') }}">
                                        お問い合わせ
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- 3カラムに変更 --}}
        <main class="">
            <div class="row">
                <div class="col-sm-12 col-md-2 p-0">
                    <div class="card">
                        <div class="card-header">タグ一覧</div>
                        <div class="card-body my-card-body">
                            <a href="/" class="btn btn-outline-warning mb-2">#すべて表示</a>
                            @foreach ($tags as $tag)
                                <a href="/?tag={{ $tag['id'] }}" class="btn btn-outline-info mb-2">#{{ $tag['name'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 p-0">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            メモ一覧
                            <a href="{{ route('home') }}">
                            <i class="fa-solid fa-circle-plus"></i></a>
                        </div>
                        <div class="card-body my-card-body">
                            @foreach ($memos as $memo)
                                <a href="/edit/{{ $memo['id'] }}" class="link-secondary d-block elipsis mb-2"><span class="fw-bold">{{ $memo->updated_at->format('Y/m/d') }}：</span>{{ $memo['content'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 p-0">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>
