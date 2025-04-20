    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Sistem Proyek Akhir')</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

            <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Optional Custom CSS --}}
        {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet"> --}}
    </head>
    <body class="bg-light">

        {{-- Header --}}
        @include('layouts.header')

        <div class="d-flex">
            {{-- Sidebar --}}
            <aside>
                <button class="menu-btn fa fa-chevron-left"></button>
                <a href="/" class="logo-wrapper">
                    <img src="{{ asset('foto/del.png') }}" alt="logo" width="40">
                    <span class="brand-name">SISTEM INFORMASI <br> PROJECT AKHIR</span>
                </a>
                <div class="separator"></div>
                <ul class="menu-items">
                    <li><a href="{{ route('mahasiswa.index') }}"><span class="icon fa fa-house"></span><span class="item-name">Home</span></a><span class="tooltip">Home</span></li>
                    <li><a href="{{ route('request-judul.index') }}"><span class="icon fa fa-lightbulb"></span><span class="item-name">AjukanJudul</span></a><span class="tooltip">AjukanJudul</span></li>
                    <li><a href="{{ route('request-bimbingan.index') }}"><span class="icon fa fa-chart-line"></span><span class="item-name">AjukanBimbingan</span></a><span class="tooltip">AjukanBimbingan</span></li>
                    <li><a href="#"><span class="icon fa fa-file-upload"></span><span class="item-name">Log Activity</span></a><span class="tooltip">AktivitasKu</span></li>
                    <li><a href="#"><span class="icon fa fa-user"></span><span class="item-name">Dokumen</span></a><span class="tooltip">Dokumen</span></li>
                    <li><a href="#"><span class="icon fa fa-gear"></span><span class="item-name">CatatanBimbingan</span></a><span class="tooltip">CatatanBimbingan</span></li>
                    <li><a href="{{ route('mahasiswa.index') }}"><span class="icon fa fa-comment-dots"></span><span class="item-name">ChatPA</span></a><span class="tooltip">ChatPA</span></li>
                    <li><a href="logout"><span class="icon fa fa-right-from-bracket"></span><span class="item-name">Logout</span></a><span class="tooltip">Logout</span></li>
                </ul>
            </aside>

            <main class="container">

                {{-- Konten Halaman --}}
                @yield('content')


            </main>

            {{-- Main Content --}}

                {{-- Pesan dari komponen --}}
                @include('komponen.pesan')

                {{-- Flash Message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Terdapat masalah dengan input Anda.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

        </div>

        {{-- Navbar Lama (disembunyikan, jika tidak digunakan hapus saja) --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4" style="display: none;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Sistem PA</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('request-judul.index') }}">Request Judul</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('request-bimbingan.index') }}">Request Bimbingan</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} ({{ Auth::user()->role ?? 'N/A' }})
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
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

        {{-- Bootstrap Bundle JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
                crossorigin="anonymous"></script>


                <script>
                    const menuBtn = document.querySelector(".menu-btn");
                    menuBtn.addEventListener("click", (e) => {
                        document.body.classList.toggle("collapsed");
                        e.currentTarget.classList.toggle("fa-chevron-right");
                        e.currentTarget.classList.toggle("fa-chevron-left");
                    });
                </script>

        {{-- Optional Custom JS --}}
        {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

        @stack('scripts')
    </body>
    </html>
