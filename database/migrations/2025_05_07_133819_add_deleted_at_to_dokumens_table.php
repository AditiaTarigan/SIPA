<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('dokumens', function (Blueprint $table) {
        $table->softDeletes(); // Ini akan menambahkan kolom 'deleted_at'
    });
}

public function down()
{
    Schema::table('dokumens', function (Blueprint $table) {
        $table->dropSoftDeletes(); // Untuk rollback
    });
}

};
