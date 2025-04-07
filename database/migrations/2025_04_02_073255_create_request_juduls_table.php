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
            Schema::create('request_juduls', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                // Pastikan foreign key merujuk ke tabel dan kolom yang benar
                // Contoh jika merujuk ke tabel 'users'
                $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
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
