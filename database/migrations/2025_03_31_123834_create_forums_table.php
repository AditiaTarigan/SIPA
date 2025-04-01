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
        Schema::create('forums', function (Blueprint $table) {
            $table->id(); // Sesuai dengan INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->string('title', 255); // Sesuai dengan VARCHAR(255) NOT NULL
            // Foreign key ke tabel users
            $table->foreignId('created_by')
                  ->constrained('users') // Mereferensikan 'id' di tabel 'users'
                  ->onDelete('cascade'); // Sesuai dengan ON DELETE CASCADE
            $table->timestamp('created_at')->nullable()->useCurrent(); // Sesuai dengan TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forums');
    }
};
