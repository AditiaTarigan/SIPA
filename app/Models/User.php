<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users'; // Explicitly defining, though likely matches convention

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime', // Assuming you want Carbon instances
            // 'role' could be cast to an Enum if using PHP 8.1+ and defined an Enum
        ];
    }

    // --- Relationships ---

    /**
     * Get the mahasiswa record associated with the user (if role is 'mahasiswa').
     */
    public function mahasiswa()
    {
        // A user has one mahasiswa profile
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }

    /**
     * Get the documents uploaded by the user (if role is 'mahasiswa').
     */
    public function dokumenPa()
    {
        // A user (as mahasiswa) can upload many documents
        // Note: FK in dokumen_pa is 'mahasiswa_id', which links to users.id
        return $this->hasMany(DokumenPa::class, 'mahasiswa_id');
    }

    /**
     * Get the forums created by the user.
     */
    public function createdForums()
    {
        // A user can create many forums
        return $this->hasMany(Forum::class, 'created_by');
    }

    /**
     * Get the forum messages posted by the user.
     */
    public function forumMessages()
    {
        // A user can post many messages
        return $this->hasMany(ForumMessage::class, 'user_id');
    }

    /**
     * Get the bimbingan history records where this user is the mahasiswa.
     */
    public function historyBimbinganMahasiswa()
    {
        // A user (as mahasiswa) has many history entries
        return $this->hasMany(HistoryBimbingan::class, 'mahasiswa_id');
    }

    /**
     * Get the bimbingan history records where this user is the dosen.
     */
    public function historyBimbinganDosen()
    {
        // A user (as dosen) has many history entries
        return $this->hasMany(HistoryBimbingan::class, 'dosen_id');
    }

     /**
     * Get the log activities submitted by the user (if role is 'mahasiswa').
     */
    public function logActivities()
    {
        // A user (as mahasiswa) can submit many log activities
        // Note: FK in log_activity is 'mahasiswa_id', which links to users.id
        return $this->hasMany(LogActivity::class, 'mahasiswa_id');
    }

    /**
     * Get the bimbingan requests made by the user (if role is 'mahasiswa').
     */
    public function requestBimbingan()
    {
        // A user (as mahasiswa) can make many requests
        // Note: FK in request_bimbingan is 'mahasiswa_id', which links to users.id
        return $this->hasMany(RequestBimbingan::class, 'mahasiswa_id');
    }

    /**
     * Get the judul requests made by the user (if role is 'mahasiswa').
     */
    public function requestJudulMahasiswa()
    {
        // A user (as mahasiswa) can make many requests
        return $this->hasMany(RequestJudul::class, 'mahasiswa_id');
    }

    /**
     * Get the judul requests directed to this user (if role is 'dosen').
     */
    public function requestJudulDosen()
    {
        // A user (as dosen) can receive many requests
        return $this->hasMany(RequestJudul::class, 'dosen_id');
    }
}
