<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_messages', function (Blueprint $table) {
            $table->id();
            // Ganti definisi forum_id dan foreign key manual
            // dengan satu baris ini:
            $table->foreignId('forum_id')
                  ->constrained('forums') // Merujuk ke tabel 'forums', kolom 'id'
                  ->onDelete('cascade');

            // ... kolom lain seperti 'user_id', 'message_content', dsb ...
            // $table->unsignedBigInteger('user_id'); // Contoh kolom lain
            // $table->text('message_content'); // Contoh kolom lain

            $table->timestamps();

            // Foreign key untuk user_id (jika ada)
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_messages');
    }
};
