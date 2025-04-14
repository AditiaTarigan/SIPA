<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = ['nim', 'prodi', 'angkatan'];
    protected $table = 'mahasiswa';
    public $timestamps = false;
}
