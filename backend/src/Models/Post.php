<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static find(mixed $getAttribute)
 */
class Post extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];
    public $timestamps = false;
    protected $table = 'posts';

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(
            PostComment::class,
            'post_id',
            'id'
        );
    }
}