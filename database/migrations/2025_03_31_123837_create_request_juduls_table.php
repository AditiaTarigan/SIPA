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
        // Nama tabel jamak: request_juduls
        Schema::create('request_juduls', function (Blueprint $table) {
            $table->id(); // Sesuai dengan INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            // Foreign key ke tabel users (merujuk pada user mahasiswa)
            $table->foreignId('mahasiswa_id')
                  ->constrained('users') // Mereferensikan 'id' di tabel 'users'
                  ->onDelete('cascade'); // Sesuai dengan ON DELETE CASCADE
            // Foreign key ke tabel users (merujuk pada user dosen)
            $table->foreignId('dosen_id')
                  ->constrained('users') // Mereferensikan 'id' di tabel 'users'
                  ->onDelete('cascade'); // Sesuai dengan ON DELETE CASCADE
            $table->string('judul', 255); // Sesuai dengan VARCHAR(255) NOT NULL
            $table->text('deskripsi')->nullable(); // Sesuai dengan TEXT NULL
            $table->timestamp('created_at')->nullable()->useCurrent(); // Sesuai dengan TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_juduls');
    }
};
