@extends('layouts.utama') {{-- Ganti dengan nama layout Anda --}}

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
        <div class="col-md-4 right-sidebar"> {{-- Sesuaikan ukuran kolom --}}
            <div class="card calendar-card">
                {{-- Header Kalender PHP/Carbon --}}
                <div class="card-header d-flex justify-content-between align-items-center py-2 px-3">
                    <a href="{{ route(Route::currentRouteName(), array_merge(request()->query(), $cal_prevMonthParams)) }}" class="btn btn-sm btn-outline-secondary">«</a>
                    <h6 class="m-0 flex-grow-1 text-center">{{ $cal_currentMonthDate->isoFormat('MMMM YYYY') }}</h6>
                    <a href="{{ route(Route::currentRouteName(), array_merge(request()->query(), $cal_nextMonthParams)) }}" class="btn btn-sm btn-outline-secondary">»</a>
                </div>
                {{-- Body Kalender PHP/Carbon --}}
                    <div class="calendar-grid-sidebar">
                        {{-- Header Hari --}}
                        @foreach ($cal_daysOfWeek as $dayName)
                            <div class="calendar-day-header-sidebar">{{ $dayName }}</div>
                        @endforeach
                        {{-- Sel Tanggal --}}
                        @foreach ($cal_calendarPeriod as $date)
                            @php
                                $dayClasses = ['calendar-day-sidebar'];
                                if (!$date->isSameMonth($cal_currentMonthDate)) { $dayClasses[] = 'other-month-sidebar'; }
                                if ($date->isToday()) { $dayClasses[] = 'is-today-sidebar'; }
                            @endphp
                            <div class="{{ implode(' ', $dayClasses) }}">
                                <div class="day-number-sidebar">{{ $date->day }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Akhir Kalender PHP/Carbon --}}
            </div>
        </div>

    </div> {{-- End Row --}}
</div> {{-- End Container --}}
@endsection

@push('styles')
{{-- Pastikan CSS Kalender ada di sini atau di file CSS utama --}}
<style>
    /* ... CSS untuk .calendar-grid-sidebar, .calendar-day-sidebar, etc. ... */
    .calendar-grid-sidebar { display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; background-color: #eee; border: 1px solid #eee; font-size: 0.8rem; }
    .calendar-day-header-sidebar, .calendar-day-sidebar { background-color: #fff; padding: 4px 2px; text-align: center; min-height: auto; line-height: 1.4; }
    .calendar-day-header-sidebar { font-weight: bold; background-color: #f8f9fa; padding: 5px 2px; }
    .day-number-sidebar { display: block; }
    .calendar-day-sidebar.other-month-sidebar { background-color: #fdfdfd; }
    .calendar-day-sidebar.other-month-sidebar .day-number-sidebar { color: #ccc; }
    .calendar-day-sidebar.is-today-sidebar .day-number-sidebar { background-color: #0d6efd; color: white; border-radius: 50%; width: 1.5em; height: 1.5em; line-height: 1.5em; display: inline-block; text-align: center; font-weight: bold; }
    .card-header .btn-sm { padding: 0.1rem 0.4rem; font-size: 0.75rem; }
    .card-header h6 { font-size: 0.9rem; }
</style>
@endpush

@push('scripts')
    {{-- Pastikan TIDAK ADA script FullCalendar.Calendar(...) di sini --}}

    {{-- Script lain yang mungkin Anda butuhkan --}}
@endpush
