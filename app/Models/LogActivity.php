<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'log_activity';

    /**
     * Timestamps configuration
     */
    public $timestamps = true;
    const CREATED_AT = 'submitted_at'; // Map to 'submitted_at'
    const UPDATED_AT = null; // No updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mahasiswa_id',
        'nama',
        'prodi',
        'no_kelompok',
        'file_log',
        // 'submitted_at' is handled by timestamps
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    /**
     * Get the user (mahasiswa) who submitted the log.
     */
    public function mahasiswa() // Or user()
    {
        // Belongs to one user (mahasiswa)
        // FK is mahasiswa_id which references users.id
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
