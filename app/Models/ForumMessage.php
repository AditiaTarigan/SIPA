<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumMessage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forum_messages';

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
        'forum_id',
        'user_id',
        'message',
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
     * Get the forum this message belongs to.
     */
    public function forum()
    {
        // A message belongs to one forum
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    /**
     * Get the user who posted the message.
     */
    public function user() // Or author()
    {
        // A message belongs to one user
        return $this->belongsTo(User::class, 'user_id');
    }
}
