@extends('layouts.utama')

{{-- Menyisipkan CSS --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}"> {{-- CSS utama Anda (sekarang termasuk style kalender) --}}
    {{-- 1. TETAP SERTAKAN CSS FullCalendar dari CDN --}}
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
    {{-- Blok <style> dihapus dari sini --}}
@endpush

@section('content')
<div class="dashboard-container">

    {{-- Kolom Konten Utama (Kiri) --}}
    <div class="main-content">
        {{-- ... Konten utama tidak berubah ... --}}

        {{-- 1. Welcome Card --}}
        <div class="card welcome-card">
            <img src="{{ asset('foto/biodata.PNG') }}" alt="Avatar" class="avatar">
            <div class="welcome-text">
                <p>Halo {{ Auth::user()->name ?? 'Pengguna' }}</p>
                <h2>SELAMAT DATANG</h2>
                <p>SIPA Vokasi IT DEL</p>
            </div>
        </div>

        {{-- 2. Project Statistics Section --}}
        <h3 class="section-title">PROJECT STATISTICS</h3>

        <div class="stats-cards-container">
           {{-- Card Dosen Pembimbing --}}
            <div class="card stat-card">
                <div class="stat-card-info">
                    <div class="stat-icon">
                        <img src="{{ asset('foto/biodata.png') }}" alt="Dosen Icon">
                    </div>
                    <div class="stat-text">
                        <h4>Dosen Pembimbing</h4>
                        <p>Dosen yang membantu mengarahkan proses pengerjaan Proyek Akhir</p>
                    </div>
                </div>
                <a href="#" class="btn btn-outline">Lihat</a>
            </div>

            {{-- Card Dokumen Proyek Akhir 1 --}}
            <div class="card stat-card">
                 <div class="stat-card-info">
                    <div class="stat-icon">
                        <img src="{{ asset('foto/5.png') }}" alt="Dokumen Icon">
                    </div>
                    <div class="stat-text">
                        <h4>Dokumen Proyek Akhir</h4>
                        <p>Dokumen untuk membantu mendokumentasikan setiap proses pengembangan Proyek Akhir</p>
                    </div>
                </div>
                <a href="{{ route('dokumen.index') ?? '#' }}" class="btn btn-outline">Lihat</a>
            </div>

            {{-- Card Dokumen Proyek Akhir 2 --}}
            <div class="card stat-card">
                 <div class="stat-card-info">
                     <div class="stat-icon">
                        <img src="{{ asset('foto/3.png') }}" alt="Dokumen Alt Icon">
                    </div>
                    <div class="stat-text">
                        <h4>Dokumen Proyek Akhir</h4>
                        <p>Dokumen untuk membantu mendokumentasikan setiap proses pengembangan Proyek Akhir</p>
                    </div>
                </div>
                <a href="#" class="btn btn-outline">Lihat</a>
            </div>
        </div>


        {{-- 3. Action Cards Section --}}
        <div class="action-cards-container">
             {{-- Card Bimbingan --}}
            <div class="card action-card">
                <a href="{{ route('request-bimbingan.index') ?? '#' }}" class="action-link">
                    <div class="action-icon">
                        <img src="{{ asset('foto/2.png') }}" alt="Bimbingan Icon">
                    </div>
                    <div class="action-text">
                        <h3>BIMBINGAN</h3>
                        <p>Pengajuan bimbingan untuk mendiskusikan progres proyek akhir</p>
                    </div>
                </a>
            </div>

            {{-- Card Log Activity --}}
            <div class="card action-card">
                 <a href="{{ route('log_activities.index') ?? '#' }}" class="action-link">
                    <div class="action-icon">
                         <img src="{{ asset('foto/6.png') }}" alt="Log Activity Icon">
                    </div>
                    <div class="action-text">
                        <h3>LOG ACTIVITY</h3>
                        <p>Submit Activitas yang dilakukan selama Proyek akhir</p>
                    </div>
                 </a>
            </div>
        </div>

    </div> {{-- End Main Content --}}


    {{-- Kolom Sidebar Kanan --}}
    <div class="right-sidebar">
        <div class="card calendar-card">
            <h4>Kalender</h4>
            {{-- Konten kalender tetap sama --}}
            <div class="calendar-content">
                <div id='calendar'></div>
            </div>
            {{-- Akhir Konten Kalender --}}
        </div>
    </div> {{-- End Right Sidebar --}}

</div> {{-- End Dashboard Container --}}
@endsection

@push('scripts')
    {{-- Bagian script tidak berubah --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/id.js'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            var calendar = new FullCalendar.Calendar(calendarEl, {
              initialView: 'dayGridMonth',
              headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'today'
              },
              locale: 'id',
              // events: [], // Tambahkan event jika ada
              height: 'auto',
              contentHeight: 350,
            });
            calendar.render();
        } else {
            console.error("Elemen #calendar tidak ditemukan.");
        }
      });
    </script>
@endpush
