<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Proyek Akhir')</title>

        <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


    {{-- Sidebar CSS Anda --}}
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <!-- Font Awesome (jika belum diimport di sidebar.css) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Optional Custom CSS per page --}}
    @stack('styles')

</head>
<body > {{-- JS akan menambah class 'collapsed' di sini --}}

    {{-- Header Aplikasi (Fixed) --}}
    <header class="app-header shadow-sm"> {{-- Tambahkan kelas app-header --}}
        {{-- Isi header Anda (misal: logo kecil, user dropdown, notifikasi) --}}
        {{-- Contoh sederhana: --}}
        <div class="container-fluid h-100 d-flex align-items-center justify-content-end">
             {{-- Placeholder untuk user info/logout di header --}}
             <span class="text-white me-3">Selamat Datang, {{ Auth::user()->name ?? 'Tamu' }}</span>
             {{-- Bisa tambahkan dropdown logout di sini --}}
        </div>
    </header>

        {{-- Bootstrap Bundle JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
                crossorigin="anonymous"></script>
    <div class="d-flex"> {{-- Container utama untuk sidebar & content --}}

        {{-- Sidebar Aplikasi (Fixed) --}}
        <aside class="app-sidebar"> {{-- Tambahkan kelas app-sidebar --}}
            <button class="menu-btn fa fa-chevron-left"></button>
            <a href="/" class="logo-wrapper">
                <img src="{{ asset('foto/del.png') }}" alt="logo">
                <span class="brand-name">SISTEM INFORMASI <br> PROJECT AKHIR</span>
            </a>
            <div class="separator"></div>
            <ul class="menu-items">
                {{-- Class 'active' bisa ditambahkan secara dinamis berdasarkan route --}}
                <li class="{{ request()->routeIs('mahasiswa.index') ? 'active' : '' }}">
                    <a href="{{ route('mahasiswa.index') }}">
                        <span class="icon fa fa-house"></span><span class="item-name">Home</span>
                    </a>
                    <span class="tooltip">Home</span>
                </li>
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
                 <li> {{-- Ganti # dgn route yg benar --}}
                    <a href="{{ route('log_activities.index') }}">
                        <span class="icon fa fa-file-upload"></span><span class="item-name">Log Activity</span>
                    </a>
                    <span class="tooltip">Aktivitas Ku</span>
                </li>
                 <li class="{{ request()->routeIs('dokumen.index') ? 'active' : '' }}">
                    <a href="{{ route('dokumen.index') }}">
                        <span class="icon fa fa-user"></span><span class="item-name">Dokumen</span>
                    </a>
                    <span class="tooltip">Dokumen</span>
                </li>
                <li class="{{ request()->routeIs('history.index') ? 'active' : '' }}">
                    <a href="{{ route('history.index') }}">
                        <span class="icon fa fa-history"></span><span class="item-name">Catatan Bimbingan</span> {{-- Ganti icon ke history? --}}
                    </a>
                    <span class="tooltip">Catatan Bimbingan</span>
                </li>
                 <li> {{-- Ganti # dgn route yg benar --}}
                    <a href="#">
                        <span class="icon fa fa-comment-dots"></span><span class="item-name">Chat PA</span>
                    </a>
                    <span class="tooltip">Chat PA</span>
                </li>
                 <li> {{-- Pastikan route 'logout' ada dan method POST --}}
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
        {{-- Hapus class="container" dari sini --}}
        <main class="app-content"> {{-- Tambahkan kelas app-content --}}

            {{-- PINDAHKAN Pesan & Flash Messages ke SINI --}}
            @include('komponen.pesan')

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

            {{-- Konten Halaman Spesifik --}}
            @yield('content')

        </main>

    </div> {{-- End .d-flex --}}


    {{-- Bootstrap Bundle JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
            crossorigin="anonymous"></script>

    {{-- Script Toggle Sidebar (Sudah Benar) --}}
    <script>
        const menuBtn = document.querySelector(".menu-btn");
        if (menuBtn) { // Cek jika elemen ada
            menuBtn.addEventListener("click", (e) => {
                document.body.classList.toggle("collapsed");
                // Toggle class icon langsung
                e.currentTarget.classList.toggle("fa-chevron-right");
                e.currentTarget.classList.toggle("fa-chevron-left");
            });

            // Optional: Cek localStorage untuk menyimpan state sidebar
            const sidebarState = localStorage.getItem('sidebarCollapsed');
            if (sidebarState === 'true') {
                document.body.classList.add('collapsed');
                menuBtn.classList.remove('fa-chevron-left');
                menuBtn.classList.add('fa-chevron-right');
            }

            // Simpan state saat diubah
             menuBtn.addEventListener("click", (e) => {
                 // ... (kode toggle class di atas) ...
                 localStorage.setItem('sidebarCollapsed', document.body.classList.contains('collapsed'));
             });
        }
    </script>

    {{-- Optional Custom JS per page --}}
    @stack('scripts')

</body>
</html>
