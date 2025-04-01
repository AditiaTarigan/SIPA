<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mahasiswas';

    /**
     * Indicates if the model should be timestamped.
     * Set to false if your table doesn't have created_at/updated_at
     * Keep true if it does (even if not in the dump, good practice)
     * @var bool
     */
    public $timestamps = false; // Your table schema doesn't show created_at/updated_at

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nim',
        'prodi',
        'angkatan',
    ];

    /**
     * Get the user that owns the mahasiswa profile.
     */
    public function user()
    {
        // A mahasiswa profile belongs to one user
        return $this->belongsTo(User::class, 'user_id');
    }

    // You could potentially add shortcuts here to relationships via the User model
    // For example, getting documents directly:
    // public function dokumenPa() {
    //     return $this->hasManyThrough(DokumenPa::class, User::class, 'id', 'mahasiswa_id', 'user_id', 'id');
    // }
    // But it might be cleaner to go through $mahasiswa->user->dokumenPa()
}
