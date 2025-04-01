<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Mengacu ke users.id sesuai FK
use App\Models\Mahasiswa;
use App\Models\LogActivity;

class LogActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswaUser1 = User::where('email', 'mahasiswa1@example.com')->first();
        // Optional: Ambil data detail mahasiswa jika diperlukan dan relasi sudah ada
        $detailMahasiswa1 = Mahasiswa::where('user_id', $mahasiswaUser1?->id)->first();

        if ($mahasiswaUser1 && $detailMahasiswa1) {
            LogActivity::create([
                'mahasiswa_id' => $mahasiswaUser1->id, // FK ke users.id
                'nama' => $mahasiswaUser1->name, // Ambil dari user
                'prodi' => $detailMahasiswa1->prodi, // Ambil dari mahasiswa
                'no_kelompok' => 'K01', // Contoh
                'file_log' => '/logbook/log_mhs1_minggu1.pdf',
                'submitted_at' => now()->subDays(10),
            ]);

             LogActivity::create([
                'mahasiswa_id' => $mahasiswaUser1->id,
                'nama' => $mahasiswaUser1->name,
                'prodi' => $detailMahasiswa1->prodi,
                'no_kelompok' => 'K01',
                'file_log' => '/logbook/log_mhs1_minggu2.pdf',
                'submitted_at' => now()->subDays(3),
            ]);
        }
        // Tambahkan log activity untuk mahasiswa lain
    }
}
