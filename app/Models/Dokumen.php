<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'prodi',
        'nomor_kelompok',
        'dokumen',
    ];
}
