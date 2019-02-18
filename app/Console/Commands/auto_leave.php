<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Leave;

class auto_leave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto_leave';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate leave records automatically when approx_entry_time is not defined before 21:00 every Tuesday/Thurday/Saturday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
    }
}
