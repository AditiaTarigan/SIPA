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
        Schema::table('request_judul', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('deskripsi'); // Atau posisi lain
            $table->text('catatan_dosen')->nullable()->after('status'); // Opsional: Untuk alasan reject/approve
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_judul', function (Blueprint $table) {
            $table->dropColumn(['status', 'catatan_dosen']);
        });
    }
};
