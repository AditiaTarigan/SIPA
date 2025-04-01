<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Forum;
use App\Models\User;
use App\Models\ForumMessage;

class ForumMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forum1 = Forum::where('title', 'Diskusi Topik Proyek Akhir Semester Ini')->first();
        $dosenUser1 = User::where('email', 'dosen1@example.com')->first();
        $mahasiswaUser1 = User::where('email', 'mahasiswa1@example.com')->first();
        $mahasiswaUser2 = User::where('email', 'mahasiswa2@example.com')->first();

        if ($forum1 && $dosenUser1 && $mahasiswaUser1 && $mahasiswaUser2) {
            ForumMessage::create([
                'forum_id' => $forum1->id,
                'user_id' => $dosenUser1->id,
                'message' => 'Selamat datang di forum diskusi topik PA. Silakan ajukan ide-ide awal kalian.',
                'created_at' => $forum1->created_at->addMinutes(5),
            ]);

            ForumMessage::create([
                'forum_id' => $forum1->id,
                'user_id' => $mahasiswaUser1->id,
                'message' => 'Baik Pak, saya tertarik dengan topik terkait Machine Learning untuk prediksi.',
                'created_at' => $forum1->created_at->addHour(),
            ]);

            ForumMessage::create([
                'forum_id' => $forum1->id,
                'user_id' => $mahasiswaUser2->id,
                'message' => 'Saya lebih tertarik ke pengembangan sistem informasi berbasis web, Pak.',
                'created_at' => $forum1->created_at->addHours(2),
            ]);
        }
        // Tambahkan pesan untuk forum lain atau user lain
    }
}
