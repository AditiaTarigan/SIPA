<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Mengacu ke users.id sesuai FK
use App\Models\Mahasiswa;
use App\Models\RequestBimbingan;

class RequestBimbinganTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswaUser1 = User::where('email', 'mahasiswa1@example.com')->first();
        $detailMahasiswa1 = Mahasiswa::where('user_id', $mahasiswaUser1?->id)->first();

        if ($mahasiswaUser1 && $detailMahasiswa1) {
            RequestBimbingan::create([
                'mahasiswa_id' => $mahasiswaUser1->id, // FK ke users.id
                'nim' => $detailMahasiswa1->nim,
                'nama' => $mahasiswaUser1->name,
                'prodi' => $detailMahasiswa1->prodi,
                'tahun_angkatan' => $detailMahasiswa1->angkatan,
                'no_kelompok' => 'K01', // Contoh
                'tanggal_bimbingan' => now()->addDays(3)->format('Y-m-d'),
                'bimbingan_ke' => 3,
                'lokasi' => 'Ruang Dosen A101',
                'jam_bimbingan' => '10:00:00',
                'tujuan_bimbingan' => 'Konsultasi hasil revisi Bab 1 dan pembahasan Bab 2.',
                'created_at' => now(),
            ]);
        }

        // Tambahkan request bimbingan lain jika perlu
    }
}
