<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Mengacu ke users.id sesuai FK
use App\Models\DokumenPa;

class DokumenPaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user mahasiswa (sesuai FK ke users.id)
        $mahasiswaUser1 = User::where('email', 'mahasiswa1@example.com')->first();

        if ($mahasiswaUser1) {
            DokumenPa::create([
                'mahasiswa_id' => $mahasiswaUser1->id, // FK ke users.id
                'nama_file' => 'Proposal_PA_Mahasiswa1.pdf',
                'file_path' => '/dokumen/proposal/proposal_pa_mhs1_rev1.pdf',
                'uploaded_at' => now(),
            ]);

             DokumenPa::create([
                'mahasiswa_id' => $mahasiswaUser1->id, // FK ke users.id
                'nama_file' => 'Laporan_Bab1_Mahasiswa1.docx',
                'file_path' => '/dokumen/laporan/laporan_bab1_mhs1.docx',
                'uploaded_at' => now()->subDays(5), // Contoh tanggal upload berbeda
            ]);
        }
         // Tambahkan dokumen untuk mahasiswa lain jika perlu
    }
}
