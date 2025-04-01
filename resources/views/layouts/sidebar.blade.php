<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('foto/del.png') }}">
    <title>SIPA</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <aside>
        <button class="menu-btn fa fa-chevron-left"></button>
        <a href="/" class="logo-wrapper">
            <img src="{{ asset('foto/del.png') }}" alt="logo">
            <span class="brand-name">SISTEM INFORMASI <br> PROJECT AKHIR</span>
        </a>
        <div class="separator"></div>
        <ul class="menu-items">
            <li><a href="#"><span class="icon fa fa-house"></span><span class="item-name">Home</span></a><span class="tooltip">Home</span></li>
            <li><a href="#"><span class="icon fa fa-lightbulb icon"></span><span class="item-name">AjukanJudul</span></a><span class="tooltip">AjukanJudul</span></li>
            <li><a href="#"><span class="icon fa fa-chart-line"></span><span class="item-name"> AjukanBimbingan</span></a><span class="tooltip">AjukanBimbingan</span></li>
            <li><a href="#"><span class="icon fa fa-file-upload icon"></span><span class="item-name">Log Activity   </span></a><span class="tooltip">AktivitasKu</span></li>
            <li><a href="#"><span class="icon fa fa-user"></span><span class="item-name">Dokumen</span></a><span class="tooltip">Dokumen</span></li>
            <li><a href="#"><span class="icon fa fa-gear"></span><span class="item-name">CatatanBimbingan</span></a><span class="tooltip">CatatanBimbingan</span></li>
            <li><a href="#"><span class="icon fa fa-comment-dots"></span><span class="item-name">ChatPA</span></a><span class="tooltip">ChatPA</span></li>
            <li><a href="logout"><span class="icon fa fa-right-from-bracket"></span><span class="item-name">Logout</span></a><span class="tooltip">Logout</span></li>
        </ul>
    </aside>
    <main>
    </main>
</div>
    <script>
        const menuBtn = document.querySelector(".menu-btn");
        menuBtn.addEventListener("click", (e) => {
            document.body.classList.toggle("collapsed");
            e.currentTarget.classList.toggle("fa-chevron-right");
            e.currentTarget.classList.toggle("fa-chevron-left");
        });
    </script>
</body>
</html>
