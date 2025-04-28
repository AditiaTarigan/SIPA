<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIPA</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
</head>
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
    <body>
    </body>
</html>
