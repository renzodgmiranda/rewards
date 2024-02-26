<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Rewards extends Model
{
    use HasFactory;

    protected $fillable = [
        'rewards_name',
        'rewards_image',
        'rewards_points',
        'rewards_quantity',
    ];

    /**
     * Added img file dump for Rewards Image
     */
    protected static function boot()
    {
        parent::boot();

        /** @var Model $model */
        static::updating(function ($model) {
            if ($model->isDirty('rewards_image') && ($model->getOriginal('rewards_image') !== null)) {
                Storage::disk('public')->delete($model->getOriginal('rewards_image'));
            }
        });

        static::deleting(function ($model) {
            if ($model->rewards_image !== null) {
                Storage::disk('public')->delete($model->rewards_image);
            }
        });
    }
}
