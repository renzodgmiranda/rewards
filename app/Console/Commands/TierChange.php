<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class TierChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tier-change';

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
        $test = User::with('roles')
            ->get()
            ->filter(
                fn ($user) => $user->toArray()
            )
            ->each(function ($users){
                $this->checkAndChangeTier($users);
            });

    }

    protected function checkAndChangeTier($user){
        if($user->points < 300){
            $user->tier = 0;
            $user->save();
        }
        elseif($user->points >= 300 && $user->points < 600){
            $user->tier = 1;
            $user->save();
        }
        elseif($user->points >= 600 && $user->points < 900){
            $user->tier = 2;
            $user->save();
        }
        elseif($user->points >= 900 && $user->points < 1200){
            $user->tier = 3;
            $user->save();
        }
        elseif($user->points >= 1200 && $user->points < 1500){
            $user->tier = 4;
            $user->save();
        }
        elseif($user->points >= 1500 && $user->points < 1800){
            $user->tier = 5;
            $user->save();
        }
        elseif($user->points >= 1800){
            $user->tier = 6;
            $user->save();
        }
        else{

        }
    }
}
