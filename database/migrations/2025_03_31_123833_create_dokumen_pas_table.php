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
        // Nama tabel jamak: dokumen_pas
        Schema::create('dokumen_pas', function (Blueprint $table) {
            $table->id(); // Sesuai dengan INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            // Foreign key ke tabel users (merujuk pada user mahasiswa)
            $table->foreignId('mahasiswa_id')
                  ->constrained('users') // Mereferensikan 'id' di tabel 'users'
                  ->onDelete('cascade'); // Sesuai dengan ON DELETE CASCADE
            $table->string('nama_file', 255); // Sesuai dengan VARCHAR(255) NOT NULL
            $table->string('file_path', 255); // Sesuai dengan VARCHAR(255) NOT NULL
            $table->timestamp('uploaded_at')->nullable()->useCurrent(); // Sesuai dengan TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pas');
    }
};
