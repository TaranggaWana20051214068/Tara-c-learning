<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') {{ config('web_config')['WEB_TITLE'] }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
    @stack('styles')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md ">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="@yield('logo', Storage::url('/images/logo/' . config('web_config')['WEB_LOGO']))" alt="Logo" height="30">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <i class="bi bi-list"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            {{-- <a class="nav-link" href="{{ route('jadwal.piket') }}">Jadwal Piket</a> --}}
                            <a class="nav-link" href="{{ route('article.index') }}">Materi</a>
                        </li>
                        <li class="nav-item">
                            {{-- <a class="nav-link" href="{{ route('jadwal.pelajaran') }}">Jadwal Pelajaran</a> --}}
                            <a class="nav-link" href="{{ route('soal.index') }}">Soal Latihan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('project.index') }}">Project</a>
                        </li>
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pembelajaran
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('article.index') }}">Materi</a>
                                <a class="dropdown-item" href="{{ route('soal.index') }}">Soal Latihan</a>
                                <a class="dropdown-item" href="{{ route('project.index') }}">Project</a>
                            </div>
                        </li> --}}
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if (auth()->user()->role !== 'siswa')
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item"><i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                            Logout</button>
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-6">Copyright &copy; {{ date('Y') }} {{ config('web_config')['WEB_TITLE'] }}
                    </div>
                    <div class="col-6 text-right">Made with <span class="bi bi-heart"></span> by <a
                            href="#">Khai</a></div>
                </div>
            </div>
            @include('layouts.footer-script')
        </footer>
    </div>
</body>

</html>
