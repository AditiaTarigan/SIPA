<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender PHP Carbon</title>
    {{-- Anda bisa menggunakan CSS Framework seperti Bootstrap atau Tailwind --}}
    {{-- Contoh sederhana dengan inline style dan sedikit CSS --}}
    <style>
        body { font-family: sans-serif; }
        .calendar-container { max-width: 900px; margin: 20px auto; padding: 15px; border: 1px solid #ccc; border-radius: 8px; }
        .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .calendar-header h2 { margin: 0; font-size: 1.5em; }
        .calendar-nav a { text-decoration: none; padding: 5px 10px; background-color: #f0f0f0; border: 1px solid #ddd; border-radius: 4px; color: #333; }
        .calendar-nav a:hover { background-color: #e0e0e0; }
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 1px; background-color: #ddd; border: 1px solid #ddd;}
        .calendar-day-header, .calendar-day { background-color: #fff; padding: 10px 5px; text-align: center; min-height: 80px; display: flex; flex-direction: column; justify-content: flex-start; align-items: center;}
        .calendar-day-header { min-height: auto; font-weight: bold; background-color: #f8f9fa; padding: 8px 5px;}
        .day-number { font-weight: bold; font-size: 0.9em; margin-bottom: 5px; align-self: flex-end; padding-right: 5px;}
        .other-month .day-number { color: #aaa; } /* Hari dari bulan lain */
        .is-today { background-color: #ffc; } /* Hari ini */
        .calendar-day.other-month { background-color: #f9f9f9; }
        /* Responsif sederhana */
        @media (max-width: 600px) {
            .calendar-day { min-height: 60px; font-size: 0.9em; padding: 5px 2px; }
            .day-number { font-size: 0.8em; }
            .calendar-header h2 { font-size: 1.2em; }
        }
    </style>
</head>
<body>

<div class="calendar-container">
    {{-- Header Kalender (Navigasi dan Judul Bulan) --}}
    <div class="calendar-header">
        <div class="calendar-nav">
            <a href="{{ route('calendar.show', $prevMonthParams) }}">« Sebelumnya</a>
        </div>
        <h2>{{ $currentMonthDate->isoFormat('MMMM YYYY') }}</h2> {{-- isoFormat untuk nama bulan lokal --}}
        <div class="calendar-nav">
            <a href="{{ route('calendar.show', $nextMonthParams) }}">Berikutnya »</a>
        </div>
    </div>

    {{-- Grid Kalender --}}
    <div class="calendar-grid">
        {{-- Header Nama Hari --}}
        @foreach ($daysOfWeek as $dayName)
            <div class="calendar-day-header">{{ $dayName }}</div>
        @endforeach

        {{-- Tanggal-tanggal dalam Grid --}}
        @foreach ($calendarPeriod as $date)
            @php
                // Tentukan class CSS untuk setiap tanggal
                $dayClasses = ['calendar-day'];
                if (!$date->isSameMonth($currentMonthDate)) {
                    $dayClasses[] = 'other-month'; // Tambahkan class jika bukan bulan ini
                }
                if ($date->isToday()) {
                    $dayClasses[] = 'is-today'; // Tambahkan class jika hari ini
                }
            @endphp
            <div class="{{ implode(' ', $dayClasses) }}">
                <div class="day-number">{{ $date->day }}</div>
                {{-- Di sini Anda bisa menambahkan logika untuk menampilkan event --}}
                {{-- Contoh: --}}
                {{-- @if (ada_event_di($date)) --}}
                {{--   <span class="event">Nama Event</span> --}}
                {{-- @endif --}}
            </div>
        @endforeach
    </div>
</div>

{{-- Jika menggunakan Bootstrap/Tailwind, pastikan JS-nya dimuat --}}
{{-- <script src="path/to/bootstrap.bundle.min.js"></script> --}}
</body>
</html>
