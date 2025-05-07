<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumen extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    // Properti yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'nama',
        'prodi',
        'nomor_kelompok',
        'dokumen', // Pastikan 'dokumen' ada di sini agar path filenya bisa disimpan
    ];

    // Jika ingin menyembunyikan atribut dari array/JSON, tambahkan di sini
    // protected $hidden = [
    //     'created_at',
    //     'updated_at',
    // ];

    // Jika perlu casting tipe data, tambahkan di sini
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    // Relasi (jika ada) bisa ditambahkan di sini
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
