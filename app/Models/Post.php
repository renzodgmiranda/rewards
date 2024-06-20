<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_owner',
        'post_title',
        'post_body',
        'post_image',
        'post_users',
        'user_id'
    ];

    protected $casts = [
        'post_users' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
