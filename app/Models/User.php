<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
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
        'items_redeemed',
        'bio',
        'wishlist'
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
        'wishlist' => 'array',
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

    public function pointHistory()
    {
        return $this->hasOne(PointHistory::class, 'id');
    }

    public function wishList()
    {
        return $this->hasMany(Rewards::class, 'wishlist');
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getProfileUrl()
    {
        $isUrl = str_contains($this->profile_photo_url, 'http');

        return ($isUrl) ? $this->profile_photo_url : Storage::disk('public')->url($this->profile_photo_url);
    }

    public function pointBarPercent($points)
    {

        $percentage = ($points / 1800) * 100;

        if($percentage > 100){
            return 100;
        }

        else{
            return $percentage;
        }

    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if(PointHistory::where('user_id', $user->id)->exists())
            {

            }
            else
            {
                PointHistory::create([
                    'user_id' => $user->id,
                    'log_user' => $user->name,
                    'log_content' => [],
                ]);

                Post::create([
                    'post_owner' => 'Teamspan Rewards',
                    'post_title' => 'Welcome to Teamspan Rewards ' . $user->name,
                    'post_body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus in tempor lacus, sed rhoncus dolor. Mauris ac ante sodales, tincidunt quam id, laoreet tortor. Phasellus vitae nulla ultrices, imperdiet est ut, posuere leo. Nunc eleifend lorem augue, vel viverra risus tempus et. Aenean eget felis massa. Nam ac odio nec.',
                    'post_users' => $user->id,
                    'user_id' => 1,
                ]);
            }

        });

    }

}
