<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestJudul extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'request_judul';

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
        'dosen_id',
        'judul',
        'deskripsi',
        // 'created_at' is handled by timestamps
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the user (mahasiswa) who made the request.
     */
    public function mahasiswa()
    {
        // Belongs to one user (mahasiswa)
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    /**
     * Get the user (dosen) to whom the request was made.
     */
    public function dosen()
    {
        // Belongs to one user (dosen)
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
