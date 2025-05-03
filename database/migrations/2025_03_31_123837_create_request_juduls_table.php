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
            Schema::create('request_judul', function (Blueprint $table) {
                $table->id();
                $table->foreignId('mahasiswa_id')
                  ->constrained('users') // Mereferensikan 'id' di tabel 'users'
                  ->onDelete('cascade'); // Sesuai dengan ON DELETE CASCADE
                $table->string('nim', 20); // Sesuai dengan VARCHAR(20) NOT NULL
                $table->string('nama', 100); // Sesuai dengan VARCHAR(100) NOT NULL
                $table->string('prodi', 100); // Sesuai dengan VARCHAR(100) NOT NULL
                $table->year('tahun_angkatan'); // Sesuai dengan YEAR NOT NULL
                $table->string('no_kelompok', 20)->nullable(); // Sesuai dengan VARCHAR(20) DEFAULT NULL
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                // Pastikan foreign key merujuk ke tabel dan kolom yang benar
                // Contoh jika merujuk ke tabel 'users'
                $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
            });
        }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_judul');
    }
};
