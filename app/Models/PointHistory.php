<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PointHistory extends Model
{
    use HasFactory;

    //log_content must contain the following: Pillar/Function, Quarter, Points, Description, Date
    protected $fillable = [
        'log_user',
        'log_content',
        'user_id',
    ];

    protected $casts = [
        'log_content' => 'array',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
