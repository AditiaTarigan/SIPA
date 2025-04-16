<!DOCTYPE html>
<html lang="id">
<head>
    <title>SIPA</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    @include('layouts.header') <!-- Menampilkan Header -->

    <div class="wrapper">
        @include('layouts.sidebar') <!-- Menampilkan Sidebar -->

        <main class="content">
            @yield('content') <!-- Bagian konten utama -->
        </main>
    </div>


</body>
</html>
