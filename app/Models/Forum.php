<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forums';

    /**
     * Timestamps configuration
     */
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null; // No updated_at in schema

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'created_by',
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
     * Get the user who created the forum.
     */
    public function creator() // Changed from user() to be specific
    {
        // A forum belongs to one user (creator)
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the messages posted in this forum.
     */
    public function messages()
    {
        // A forum has many messages
        return $this->hasMany(ForumMessage::class, 'forum_id');
    }
}
