<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BadgeBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_name',
        'badge_image',
        'badge_owner',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'badge_owner');
    }

    public function scopeOwner($query, User $user)
    {
        $query->where('badge_owner', $user->id);
    }

    public function getBadgeUrl()
    {
        $isUrl = str_contains($this->badge_image, 'http');

        return ($isUrl) ? $this->badge_image : Storage::disk('public')->url($this->badge_image);
    }
}
