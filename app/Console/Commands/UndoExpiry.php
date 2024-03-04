<?php

namespace App\Console\Commands;

use App\Mail\RewardsRedeemed;
use App\Models\RedeemHistory;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class UndoExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:undo-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        RedeemHistory::whereNotNull('expiry')
        ->where('redeemed_status', 'Processing')
        ->get()
        ->each(function ($redeem) use ($now){
            $expiryUndoButton = $redeem->created_at->addMinutes($redeem->expiry);
            if ($now->greaterThan($expiryUndoButton) && $redeem->redeemed_status = 'Processing'){
                $this->changeStatus($redeem);
            }
        });
    }

    protected function changeStatus($redeem){
        $redeem->redeemed_status = "Unclaimed";
        $redeem->save();
        $admin = User::where('id', 1)->first();
        Mail::to($admin->email)->send(new RewardsRedeemed($redeem));
    }
}
