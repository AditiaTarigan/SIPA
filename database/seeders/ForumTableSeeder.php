<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Forum;

class ForumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dosenUser1 = User::where('email', 'dosen1@example.com')->first();
        $adminUser = User::where('email', 'admin@example.com')->first();

        if ($dosenUser1) {
            Forum::create([
                'title' => 'Diskusi Topik Proyek Akhir Semester Ini',
                'created_by' => $dosenUser1->id,
                'created_at' => now(),
            ]);
        }

        if ($adminUser) {
             Forum::create([
                'title' => 'Pengumuman Jadwal Seminar Proposal',
                'created_by' => $adminUser->id,
                'created_at' => now()->subDays(2),
            ]);
        }
        // Tambahkan forum lain jika perlu
    }
}
