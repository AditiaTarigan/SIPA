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
        // Mengikuti konvensi Laravel, nama tabel jamak: mahasiswas
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id(); // Sesuai dengan INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            // Foreign key ke tabel users
            $table->foreignId('user_id')
                  ->unique() // Sesuai dengan UNIQUE KEY `user_id`
                  ->constrained('users') // Mereferensikan 'id' di tabel 'users'
                  ->onDelete('cascade'); // Sesuai dengan ON DELETE CASCADE
            $table->string('nim', 20)->unique(); // Sesuai dengan VARCHAR(20) NOT NULL UNIQUE
            $table->string('prodi', 100); // Sesuai dengan VARCHAR(100) NOT NULL
            $table->year('angkatan'); // Sesuai dengan YEAR NOT NULL
            // Tidak ada timestamps di SQL dump untuk tabel ini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
