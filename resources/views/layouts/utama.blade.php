<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Proyek Akhir')</title>

    <!-- Bootstrap CSS (Hanya perlu satu kali import) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    {{-- Sidebar CSS Anda --}}
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Optional Custom CSS per page --}}
    @stack('styles')

</head>
<body > {{-- JS akan menambah class 'collapsed' di sini --}}

    {{-- Hapus blok @auth/@guest yang salah tempat di sini --}}

    @include('layouts.header') {{-- Menampilkan Header (jika ada, atau sidebar toggle mungkin ada di sini) --}}

    <div class="d-flex"> {{-- Container utama untuk sidebar & content --}}

        {{-- Sidebar Aplikasi (Fixed) --}}
        <aside class="app-sidebar"> {{-- Tambahkan kelas app-sidebar --}}
            <button class="menu-btn fas fa-chevron-left"></button>
            <a href="/" class="logo-wrapper"> {{-- Logo sebaiknya link ke halaman utama non-dashboard atau '/' --}}
                <img src="{{ asset('foto/del.png') }}" alt="logo">
                <span class="brand-name">SISTEM INFORMASI <br> PROJECT AKHIR</span>
            </a>
            <div class="separator"></div>
            <ul class="menu-items">
                {{-- ======================================================= --}}
                {{-- AWAL PERUBAHAN: Link Home Dinamis --}}
                {{-- ======================================================= --}}
                @auth {{-- Pastikan user login untuk menampilkan menu ini --}}
                    @php
                        // Tentukan route name dan route parameter (jika ada) berdasarkan role
                        $homeRouteName = 'login'; // Default jika role tidak cocok (seharusnya tidak terjadi di dalam @auth)
                        if (Auth::user()->role == 'dosen') {
                            $homeRouteName = 'Dosen.Dashboard';
                        } elseif (Auth::user()->role == 'mahasiswa') {
                            $homeRouteName = 'Mhs.Dashboard';
                        }
                        // Tambahkan elseif untuk role lain jika perlu
                        // elseif (Auth::user()->role == 'admin') {
                        //     $homeRouteName = 'Admin.Dashboard';
                        // }
                    @endphp

                    {{-- Buat item list, cek 'active' berdasarkan route name yang sudah ditentukan --}}
                    <li class="{{ request()->routeIs($homeRouteName) ? 'active' : '' }}">
                        <a href="{{ route($homeRouteName) }}"> {{-- Gunakan route name dinamis --}}
                            <span class="icon fa fa-house"></span><span class="item-name">Home</span>
                        </a>
                        <span class="tooltip">Home</span>
                    </li>
                @endauth
                {{-- ======================================================= --}}
                {{-- AKHIR PERUBAHAN: Link Home Dinamis --}}
                {{-- ======================================================= --}}


                 {{-- Menu lainnya (pastikan route name dan active check sesuai) --}}
                 <li class="{{ request()->routeIs('request-judul.index') ? 'active' : '' }}">
                    <a href="{{ route('request-judul.index') }}">
                        <span class="icon fa fa-lightbulb"></span><span class="item-name">Ajukan Judul</span>
                    </a>
                    <span class="tooltip">Ajukan Judul</span>
                </li>
                 <li class="{{ request()->routeIs('request-bimbingan.index') ? 'active' : '' }}">
                    <a href="{{ route('request-bimbingan.index') }}">
                        <span class="icon fa fa-chart-line"></span><span class="item-name">Ajukan Bimbingan</span>
                    </a>
                    <span class="tooltip">Ajukan Bimbingan</span>
                </li>
                 <li class="{{ request()->routeIs('log_activities.index') ? 'active' : '' }}"> {{-- Tambahkan cek active jika perlu --}}
                    <a href="{{ route('log_activities.index') }}">
                        <span class="icon fa fa-file-upload"></span><span class="item-name">Log Activity</span>
                    </a>
                    <span class="tooltip">Aktivitas Ku</span>
                </li>
                 <li class="{{ request()->routeIs('dokumen.index') ? 'active' : '' }}">
                    <a href="{{ route('dokumen.index') }}">
                        <span class="icon fa fa-user"></span><span class="item-name">Dokumen</span> {{-- Icon mungkin perlu diganti ke file? --}}
                    </a>
                    <span class="tooltip">Dokumen</span>
                </li>
                <li class="{{ request()->routeIs('history.index') ? 'active' : '' }}">
                    <a href="{{ route('history.index') }}">
                        <span class="icon fa fa-history"></span><span class="item-name">Catatan Bimbingan</span>
                    </a>
                    <span class="tooltip">Catatan Bimbingan</span>
                </li>
                 <li> {{-- Ganti # dgn route yg benar jika fitur Chat sudah ada --}}
                    <a href="#">
                        <span class="icon fa fa-comment-dots"></span><span class="item-name">Chat PA</span>
                    </a>
                    <span class="tooltip">Chat PA</span>
                </li>
                 <li> {{-- Logout Link --}}
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                        <span class="icon fa fa-right-from-bracket"></span><span class="item-name">Logout</span>
                    </a>
                     <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <span class="tooltip">Logout</span>
                </li>
            </ul>
        </aside>

        {{-- Konten Utama Aplikasi --}}
        <main class="app-content"> {{-- Tambahkan kelas app-content --}}

            {{-- Alert Messages --}}
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
            {{-- End Alert Messages --}}

            {{-- Konten Halaman Spesifik --}}
            @yield('content')

        </main>

    </div> {{-- End .d-flex --}}


    {{-- Bootstrap Bundle JS (Hanya perlu satu kali import) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
            crossorigin="anonymous"></script>

    {{-- Script Toggle Sidebar --}}
    <script>
        const menuBtn = document.querySelector(".menu-btn");
        if (menuBtn) {
            // Function to apply initial state and update icon
            const applySidebarState = () => {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                document.body.classList.toggle("collapsed", isCollapsed);
                menuBtn.classList.toggle("fas-chevron-right", isCollapsed);
                menuBtn.classList.toggle("fas-chevron-left", !isCollapsed);
            };

            // Apply state on page load
            applySidebarState();

            // Add click listener
            menuBtn.addEventListener("click", (e) => {
                const bodyCollapsed = document.body.classList.toggle("collapsed");
                localStorage.setItem('sidebarCollapsed', bodyCollapsed); // Save new state
                // Update icon immediately
                e.currentTarget.classList.toggle("fas-chevron-right", bodyCollapsed);
                e.currentTarget.classList.toggle("fas-chevron-left", !bodyCollapsed);
            });
        }
    </script>

    {{-- Optional Custom JS per page --}}
    @stack('scripts')

</body>
</html>
