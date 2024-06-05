<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetScoreAnually extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-score-anually';

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
        $users = User::with('roles')
            ->get()
            ->each(function ($users){
                $this->resetPointsAnually($users);
            });
    }

    protected function resetPointsAnually ($users){

        $users->update([
            'points' => 0,
            'srs_points' => 0,
            'hw_points' => 0,
            'tw_points' => 0,
            'q1_points' => 0,
            'q2_points' => 0,
            'q3_points' => 0,
            'q4_points' => 0,
        ]);
    }
}
