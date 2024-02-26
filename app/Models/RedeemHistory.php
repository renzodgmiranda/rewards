<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RedeemHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'redeemed_name',
        'redeemed_image',
        'redeemed_points',
        'redeemed_quantity',
        'redeemed_status',
        'redeemed_by',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'redeemed_by');
    }
    
}
