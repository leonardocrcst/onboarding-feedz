<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $data)
 * @method static find(mixed $getAttribute)
 */
class User extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'email',
        'password'
    ];
    protected $hidden = ['password'];
    public $timestamps = false;
    protected $table = 'users';

    public function posts(): HasMany
    {
        return $this->hasMany(
            Post::class,
            'user_id',
            'id'
        );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(
            PostComment::class,
            'user_id',
            'id'
        );
    }
}