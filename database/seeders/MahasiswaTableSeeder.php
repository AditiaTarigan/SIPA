<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;

class MahasiswaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user yang berperan sebagai mahasiswa
        $mahasiswaUser1 = User::where('email', 'if324038')->first();
        $mahasiswaUser2 = User::where('email', 'if324020')->first();
        $mahasiswaUser3 = User::where('email', 'if424065')->first();

        if ($mahasiswaUser1) {
            Mahasiswa::create([
                'user_id' => $mahasiswaUser1->id,
                'nim' => '42324038',
                'prodi' => 'Teknologi Informasi',
                'angkatan' => '2024',
            ]);
        }

        if ($mahasiswaUser2) {
            Mahasiswa::create([
                'user_id' => $mahasiswaUser2->id,
                'nim' => '43324020',
                'prodi' => 'Teknologi Komputer',
                'angkatan' => '2024',
            ]);
        }

        if ($mahasiswaUser3) {
            Mahasiswa::create([
                'user_id' => $mahasiswaUser3->id,
                'nim' => '41324065',
                'prodi' => 'Teknologi Rekayasa Perangkat Lunak',
                'angkatan' => '2024',
            ]);
        }

        // Tambahkan data mahasiswa lain jika perlu
    }
}
