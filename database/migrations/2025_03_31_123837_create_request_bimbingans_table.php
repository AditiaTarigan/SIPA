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
        // Nama tabel jamak: request_bimbingans
        Schema::create('request_bimbingans', function (Blueprint $table) {
            $table->id(); // Sesuai dengan INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            // Foreign key ke tabel users (merujuk pada user mahasiswa)
            $table->foreignId('mahasiswa_id')
                  ->constrained('users') // Mereferensikan 'id' di tabel 'users'
                  ->onDelete('cascade'); // Sesuai dengan ON DELETE CASCADE
            $table->string('nim', 20); // Sesuai dengan VARCHAR(20) NOT NULL
            $table->string('nama', 100); // Sesuai dengan VARCHAR(100) NOT NULL
            $table->string('prodi', 100); // Sesuai dengan VARCHAR(100) NOT NULL
            $table->year('tahun_angkatan'); // Sesuai dengan YEAR NOT NULL
            $table->string('no_kelompok', 20)->nullable(); // Sesuai dengan VARCHAR(20) DEFAULT NULL
            $table->date('tanggal_bimbingan'); // Sesuai dengan DATE NOT NULL
            $table->integer('bimbingan_ke'); // Sesuai dengan INT NOT NULL
            $table->string('lokasi', 255); // Sesuai dengan VARCHAR(255) NOT NULL
            $table->time('jam_bimbingan'); // Sesuai dengan TIME NOT NULL
            $table->text('tujuan_bimbingan'); // Sesuai dengan TEXT NOT NULL
            $table->timestamp('created_at')->nullable()->useCurrent(); // Sesuai dengan TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_bimbingans');
    }
};
