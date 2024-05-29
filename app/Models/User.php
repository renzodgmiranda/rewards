<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account',
        'points',
        'tier',
        'used_points',
        'srs_points',
        'hw_points',
        'tw_points',
        'q1_points',
        'q2_points',
        'q3_points',
        'q4_points',
        'items_redeemed'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function redeem(): HasMany
    {
        return $this->hasMany(RedeemHistory::class, 'name');
    }

    public function hasAnyRole($roles) {
        return $this->roles->whereIn('name', $roles)->isNotEmpty();
    }

    public function badges()
    {
        return $this->hasMany(BadgeBoard::class, 'name');
    }
}
