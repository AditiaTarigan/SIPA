<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,          // Harus pertama karena tabel lain bergantung pada users
            MahasiswaTableSeeder::class,      // Bergantung pada Users
            ForumTableSeeder::class,          // Bergantung pada Users (created_by)

            // Seeder berikut bergantung pada Users (mahasiswa_id/dosen_id) dan/atau Forum
            // Urutan setelah ini relatif lebih bebas, selama dependensinya sudah terpenuhi
            DokumenPaTableSeeder::class,      // Bergantung pada Users (mahasiswa_id)
            ForumMessagesTableSeeder::class,  // Bergantung pada Forum dan Users
            HistoryBimbinganTableSeeder::class, // Bergantung pada Users (mahasiswa_id, dosen_id)
            LogActivityTableSeeder::class,    // Bergantung pada Users (mahasiswa_id) -> sebaiknya juga Mahasiswa untuk data detail
            RequestBimbinganTableSeeder::class, // Bergantung pada Users (mahasiswa_id) -> sebaiknya juga Mahasiswa untuk data detail
            RequestJudulTableSeeder::class,    // Bergantung pada Users (mahasiswa_id, dosen_id)

        ]);
    }
}
