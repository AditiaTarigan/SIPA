<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Proyek Akhir')</title>
    <!-- Include CSS (Bootstrap 5.1.3) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link your own CSS if you have any -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    {{-- Link sidebar CSS if it's separate and needed here --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"> --}}
    <!-- Font Awesome if used in header/footer -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> {{-- Example --}}
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    {{-- Include Header --}}
    @include('layouts.header')

    {{-- Include Sidebar - Adjust structure if sidebar should wrap content --}}
    {{-- Common structure: Sidebar pushes main content --}}
    <div class="d-flex"> {{-- Use flexbox for sidebar layout if applicable --}}
        @include('layouts.sidebar')

        {{-- Main Content Area --}}
        <main class="content-wrapper flex-grow-1 p-4"> {{-- Adjust classes as needed --}}

            <!-- Display Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error')) {{-- Added session 'error' check --}}
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

            {{-- Inject page-specific content --}}
            @yield('content')

        </main>
    </div>


    {{-- Old Navbar - You might want to remove this if header/sidebar covers all navigation --}}
    {{-- OR integrate its elements into the header include --}}
    {{-- Keeping it for now as per your original code --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4" style="display: none;"> {{-- Added style="display: none;" assuming header is primary nav now --}}
                                                                                         {{-- REMOVE style="display: none;" if you still need this navbar --}}
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Sistem PA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

                        {{-- ======================================= --}}
                        {{-- MODIFICATION: Add Request Bimbingan Link --}}
                        {{-- ======================================= --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('request-bimbingan.index') }}">Request Bimbingan</a>
                        </li>
                        {{-- ======================================= --}}
                        {{-- END MODIFICATION                      --}}
                        {{-- ======================================= --}}

                        <!-- Tambahkan menu lain sesuai role -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} ({{ Auth::user()->role ?? 'N/A' }}) {{-- Added null coalescing for role --}}
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

    {{-- Removed the duplicate <main> tag --}}

    <!-- Include JS (Bootstrap Bundle 5.1.3) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Include your own JS if you have any --}}
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    @stack('scripts') <!-- For page-specific scripts -->
</body>
</html>
