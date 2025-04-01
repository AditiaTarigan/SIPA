<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestBimbingan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'request_bimbingan';

     /**
     * Timestamps configuration
     */
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; // No updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mahasiswa_id',
        'nim',
        'nama',
        'prodi',
        'tahun_angkatan',
        'no_kelompok',
        'tanggal_bimbingan',
        'bimbingan_ke',
        'lokasi',
        'jam_bimbingan',
        'tujuan_bimbingan',
        // 'created_at' is handled by timestamps
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'tanggal_bimbingan' => 'date',
        'jam_bimbingan' => 'datetime:H:i:s', // Or just 'time' depending on needs
        'tahun_angkatan' => 'integer', // YEAR can be treated as integer
        'bimbingan_ke' => 'integer',
    ];


    /**
     * Get the user (mahasiswa) who made the request.
     */
    public function mahasiswa() // Or requester() or user()
    {
        // Belongs to one user (mahasiswa)
        // FK is mahasiswa_id which references users.id
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
