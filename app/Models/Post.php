<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_owner',
        'post_title',
        'post_body',
        'post_image',
        'post_users',
        'post_owner_profile',
        'user_id'
    ];

    protected $casts = [
        'post_users' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getReadingTime()
    {
        $mins = round(str_word_count($this->post_body) / 250);

        return ($mins < 1) ? 1 : $mins;
    }

    public function getProfileUrl()
    {
        $isUrl = str_contains($this->post_owner_profile, 'http');

        return ($isUrl) ? $this->post_owner_profile : Storage::disk('public')->url($this->post_owner_profile);
    }
}
