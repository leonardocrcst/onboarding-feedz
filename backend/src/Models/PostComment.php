<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostComment extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'comment',
        'post_id',
        'user_id'
    ];
    public $timestamps = false;
    protected $table = 'posts_comments';

    public function post(): BelongsTo
    {
        return $this->belongsTo(
            Post::class,
            'post_id',
            'id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }
}