<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dokumen_pa';

    /**
     * Indicates if the model should be timestamped.
     * Your table has `uploaded_at` but not `updated_at`.
     * If you only want `created_at` (or in this case `uploaded_at`), manage it like this:
     *
     * @var bool
     */
    public $timestamps = true; // Enable timestamps

    const CREATED_AT = 'uploaded_at'; // Map Laravel's created_at to your column
    const UPDATED_AT = null; // Disable updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mahasiswa_id',
        'nama_file',
        'file_path',
        // 'uploaded_at' is handled automatically by timestamps
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    /**
     * Get the user (mahasiswa) who uploaded the document.
     */
    public function mahasiswa() // Or user() if you prefer clarity that it's a User model
    {
        // A document belongs to one user (mahasiswa)
        // FK is mahasiswa_id which references users.id
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
