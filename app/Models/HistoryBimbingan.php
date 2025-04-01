<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryBimbingan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'history_bimbingan';

    /**
     * Timestamps configuration
     */
    public $timestamps = true;
    const CREATED_AT = 'tanggal'; // Map to 'tanggal'
    const UPDATED_AT = null; // No updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'catatan',
        // 'tanggal' is handled by timestamps
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal' => 'datetime',
    ];

    /**
     * Get the user (mahasiswa) associated with this history entry.
     */
    public function mahasiswa()
    {
        // Belongs to one user (mahasiswa)
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    /**
     * Get the user (dosen) associated with this history entry.
     */
    public function dosen()
    {
        // Belongs to one user (dosen)
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
