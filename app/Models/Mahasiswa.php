<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = [
        'nim',
        'nama',             // <-- Ditambahkan
        'prodi',
        'nomor_kelompok',   // <-- Ditambahkan
        'dosen_pembimbing', // <-- Ditambahkan
        'angkatan'
    ];
    protected $table = 'mahasiswa';
    public $timestamps = false;
}
