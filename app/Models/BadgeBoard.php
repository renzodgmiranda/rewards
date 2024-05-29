<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
