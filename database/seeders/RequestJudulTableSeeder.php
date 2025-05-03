<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Mengacu ke users.id sesuai FK
use App\Models\RequestJudul;

class RequestJudulTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswaUser1 = User::where('email', 'mahasiswa1@example.com')->first();
        $mahasiswaUser2 = User::where('email', 'mahasiswa2@example.com')->first();
        $dosenUser1 = User::where('email', 'dosen1@example.com')->first();
        $dosenUser2 = User::where('email', 'dosen2@example.com')->first();

        if ($mahasiswaUser1 && $dosenUser1) {
            RequestJudul::create([
                'mahasiswa_id' => $mahasiswaUser1->id, // FK ke users.id
                'nim' => $mahasiswaUser1->nim,
                'nama' => $mahasiswaUser1->name,
                'prodi' => $mahasiswaUser1->prodi,
                'tahun_angkatan' => $mahasiswaUser1->angkatan,
                'no_kelompok' => 'K01', // Contoh
                'dosen_id' => $dosenUser1->id,       // FK ke users.id
                'judul' => 'Implementasi Algoritma KNN untuk Klasifikasi Citra Batik',
                'deskripsi' => 'Mengajukan judul terkait klasifikasi citra menggunakan K-Nearest Neighbors.',
                'created_at' => now()->subWeeks(3),
            ]);
        }

        if ($mahasiswaUser2 && $dosenUser2) {
             RequestJudul::create([
                'mahasiswa_id' => $mahasiswaUser2->id, // FK ke users.id
                'nim' => $mahasiswaUser1->nim,
                'nama' => $mahasiswaUser1->name,
                'prodi' => $mahasiswaUser1->prodi,
                'tahun_angkatan' => $mahasiswaUser1->angkatan,
                'no_kelompok' => 'K02', // Contoh
                'dosen_id' => $dosenUser2->id,       // FK ke users.id
                'judul' => 'Pengembangan Sistem Informasi Akademik Berbasis Laravel dan Vue.js',
                'deskripsi' => 'Pengajuan judul untuk membangun sistem informasi akademik.',
                'created_at' => now()->subWeeks(2),
            ]);
        }

         // Tambahkan request judul lain jika perlu
    }
}
