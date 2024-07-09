<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
        'redeemed_user_note',
        'expiry',
        'user_id',
        'rewards_id',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'redeemed_by');
    }

    public function scopeRecentlyclaimed($query, User $user)
    {
        $query->where('redeemed_status', 'Redeemed')->where('redeemed_by', $user->name);
    }

    public function getRedeemUrl()
    {
        $isUrl = str_contains($this->redeemed_image, 'http');

        return ($isUrl) ? $this->redeemed_image : Storage::disk('public')->url($this->redeemed_image);
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($records) {
            if($records->redeemed_status == 'Unclaimed'){

                $logData = [];
                $currentDate = now()->format('Y-m-d');
                $quarter = ceil(date('n') / 3);

                $pillar = 'Rewards';
                $criteria = 'User Redeemed ' . $records->redeemed_name;
                $points = $records->redeemed_points;

                $logData[] = [
                    'Pillar' => $pillar,
                    'Quarter' => "Q$quarter",
                    'Points' => $points * -1,
                    'Description' => $criteria,
                    'Date' => $currentDate,
                ];

                $pointLog = PointHistory::firstOrNew([
                    'user_id' => $records->user_id,
                ]);

                if ($pointLog->exists) {
                    // If the log exists, merge the new data with the existing data
                    $existingLogData = $pointLog->log_content;
                    $updatedLogData = array_merge($existingLogData, $logData);
                    $pointLog->log_content = $updatedLogData;
                } else {
                    // If it's a new log, just use the new data
                    $pointLog->log_content = $logData;
                }

                $pointLog->save();
            }
        });

    }

    public function changeStatus(array $data, RedeemHistory $status){

        $newStatus = $data['redeemed_status'];
        $redeemer = $status->redeemed_by;
        $redeemerId = $status->user_id;

        $user = User::where('name', '=', $redeemer)->where('id', $redeemerId)->first();

        $status->update([
            'redeemed_status' => $newStatus
        ]);

        if($status->redeemed_status === 'Redeemed'){
            $user->update([
                'items_redeemed' => $user->items_redeemed + 1
            ]);
        }

        Notification::make()
                ->title(fn (): string => __("Successfully Changed Status to {$newStatus}"))
                ->success()
                ->send();

        return ;

    }

}
