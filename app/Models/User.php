<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

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
        'two_factor_recovery_codes',
        'two_factor_secret',
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


    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function pointBarPercent()
    {
        $user = auth()->user();

        $percentage = ($user->points / 1800) * 100;

        if($percentage > 100){
            return 100;
        }

        else{
            return $percentage;
        }

    }
}
