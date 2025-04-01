<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Mengacu ke users.id sesuai FK
use App\Models\HistoryBimbingan;

class HistoryBimbinganTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswaUser1 = User::where('email', 'mahasiswa1@example.com')->first();
        $dosenUser1 = User::where('email', 'dosen1@example.com')->first();

        if ($mahasiswaUser1 && $dosenUser1) {
            HistoryBimbingan::create([
                'mahasiswa_id' => $mahasiswaUser1->id, // FK ke users.id
                'dosen_id' => $dosenUser1->id,       // FK ke users.id
                'tanggal' => now()->subWeeks(2),
                'catatan' => 'Diskusi awal pemilihan topik. Mahasiswa menunjukkan minat pada ML.',
            ]);

             HistoryBimbingan::create([
                'mahasiswa_id' => $mahasiswaUser1->id,
                'dosen_id' => $dosenUser1->id,
                'tanggal' => now()->subWeek(),
                'catatan' => 'Review draft proposal Bab 1. Perlu perbaikan pada latar belakang.',
            ]);
        }
         // Tambahkan history untuk mahasiswa/dosen lain
    }
}
