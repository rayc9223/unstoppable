<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\User;
use App\Leave;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function(){
            $undefined_users = User::where('approx_entry_time', '')->get();
            foreach ($undefined_users as $user) {
                $leave = new Leave();
                $leave->uid = $user->uid;
                $leave->gameid = $user->gameid;
                $leave->guild = $user->guild ? $user->guild : '未設定';
                $leave->reason = '逾時未設定';
                $leave->call_leave_time = time();
                $leave->save();
            }        
        // })->weekly()->tuesdays()->thursdays()->saturdays()->at('21:00');
        })->weekly()->mondays()->at('21:17');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
