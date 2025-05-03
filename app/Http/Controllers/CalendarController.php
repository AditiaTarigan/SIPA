<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CalendarController extends Controller
{
    public function show(Request $request)
    {
        // 1. Tentukan Bulan dan Tahun yang Akan Ditampilkan
        // Ambil dari request jika ada, jika tidak, gunakan bulan dan tahun saat ini.
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        // Buat objek Carbon untuk tanggal 1 di bulan dan tahun yang dipilih
        // Ini akan menjadi referensi utama kita
        try {
            $currentMonthDate = Carbon::createFromDate($year, $month, 1)->startOfDay();
        } catch (\Carbon\Exceptions\InvalidDateException $e) {
            // Jika input bulan/tahun tidak valid, kembali ke bulan saat ini
            return redirect()->route('calendar.show')->with('error', 'Bulan atau Tahun tidak valid.');
        }


        // 2. Dapatkan Tanggal Pertama dan Terakhir di Bulan Tersebut
        $firstDayOfMonth = $currentMonthDate->copy()->startOfMonth();
        $lastDayOfMonth = $currentMonthDate->copy()->endOfMonth();

        // 3. Tentukan Tanggal Mulai dan Akhir untuk Grid Kalender
        // Kita perlu menampilkan beberapa hari dari bulan sebelumnya dan sesudahnya
        // agar grid kalender penuh (biasanya 6 baris).
        // Tentukan hari pertama dalam seminggu (Misal: Minggu = 0, Senin = 1)
        // Carbon::SUNDAY atau Carbon::MONDAY
        $startDayOfWeek = Carbon::SUNDAY; // Ganti ke Carbon::MONDAY jika ingin mulai dari Senin

        // Tanggal pertama yang akan ditampilkan di grid (bisa jadi dari bulan sebelumnya)
        $startOfGrid = $firstDayOfMonth->copy()->startOfWeek($startDayOfWeek);

        // Tanggal terakhir yang akan ditampilkan di grid (bisa jadi dari bulan sesudahnya)
        $endOfGrid = $lastDayOfMonth->copy()->endOfWeek($startDayOfWeek);

        // 4. Buat Periode Tanggal untuk Grid
        // CarbonPeriod memudahkan membuat rentang tanggal
        $calendarPeriod = CarbonPeriod::create($startOfGrid, $endOfGrid);

        // 5. Siapkan Data untuk Navigasi
        $prevMonthDate = $currentMonthDate->copy()->subMonthNoOverflow();
        $nextMonthDate = $currentMonthDate->copy()->addMonthNoOverflow();

        // 6. Siapkan Nama Hari dalam Seminggu
        // Sesuaikan urutan berdasarkan $startDayOfWeek
        if ($startDayOfWeek === Carbon::SUNDAY) {
            $daysOfWeek = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        } else {
            $daysOfWeek = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        }

        // 7. Kirim Data ke View
        return view('kalender', [
            'currentMonthDate' => $currentMonthDate, // Untuk menampilkan nama bulan/tahun
            'calendarPeriod'   => $calendarPeriod,   // Semua tanggal dalam grid
            'daysOfWeek'       => $daysOfWeek,       // Nama-nama hari
            'prevMonthParams'  => ['month' => $prevMonthDate->month, 'year' => $prevMonthDate->year],
            'nextMonthParams'  => ['month' => $nextMonthDate->month, 'year' => $nextMonthDate->year],
        ]);
    }
}
