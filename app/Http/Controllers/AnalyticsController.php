<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
use Session;

class AnalyticsController extends Controller
{
    public function analysisAll(){
        $total_users = DB::table('users')->count();

        $highest_roll_qty = DB::table('users')->max('roll_qty');

        $lowest_roll_qty = DB::table('users')->min('roll_qty');

        $approx_case_1 = DB::table('users')->where('approx_entry_time', '準時進場')->get();

        $approx_case_2 = DB::table('users')->where('approx_entry_time', '晚到10分鐘')->get();

        $approx_case_3 = DB::table('users')->where('approx_entry_time', '晚到11~20分鐘')->get();

        $approx_case_4 = DB::table('users')->where('approx_entry_time', '晚到30分鐘以上')->get();

        $approx_case_5 = DB::table('users')->where('approx_entry_time', '無法參加本次爭奪')->get();

        $approx_case_6 = DB::table('users')->where('approx_entry_time', '')->get();

        $guildwar_p1 = DB::table('users')->where('guildwar_phase_1','<>', '')->get();

        $guildwar_p1_buff = DB::table('users')->where('guildwar_phase_1', '增益：鬼怪組')->get();

        $guildwar_p1_taiho = DB::table('users')->where('guildwar_phase_1', '大豪城')->get();

        $guildwar_p1_linmo = DB::table('users')->where('guildwar_phase_1', '蓮慕城')->get();

        $guildwar_p1_choilo = DB::table('users')->where('guildwar_phase_1', '賽羅城')->get();

        $guildwar_p1_undefined = DB::table('users')->where('guildwar_phase_1', '')->get();

        $guildwar_p2 = DB::table('users')->where('guildwar_phase_2','<>', '')->get();

        $guildwar_p2_urban = DB::table('users')->where('guildwar_phase_2', '城外郊區組')->get();

        $guildwar_p2_forbidden = DB::table('users')->where('guildwar_phase_2', '皇城內組')->get();

        $guildwar_p2_palace = DB::table('users')->where('guildwar_phase_2', '皇宮組')->get();

        $guildwar_p2_undefined = DB::table('users')->where('guildwar_phase_2', '')->get();

        return view('analysis', ['total_users'=>$total_users,
                                'max_roll'=>$highest_roll_qty,
                                'min_roll'=>$lowest_roll_qty,
                                'ontime'=>$approx_case_1,
                                'approx_case_2'=>$approx_case_2,
                                'approx_case_3'=>$approx_case_3,
                                'approx_case_4'=>$approx_case_4,
                                'absent'=>$approx_case_5,
                                'approx_undefined'=>$approx_case_6,
                                'guildwar_p1_registered'=>$guildwar_p1,
                                'guildwar_p1_buff'=>$guildwar_p1_buff,
                                'taiho'=>$guildwar_p1_taiho,
                                'linmo'=>$guildwar_p1_linmo,
                                'choilo'=>$guildwar_p1_choilo,
                                'guildwar_p1_undefined'=>$guildwar_p1_undefined,
                                'guildwar_p2_registered'=>$guildwar_p2,
                                'guildwar_p2_urban'=>$guildwar_p2_urban,
                                'guildwar_p2_forbidden'=>$guildwar_p2_forbidden,
                                'guildwar_p2_palace'=>$guildwar_p2_palace,
                                'guildwar_p2_undefined'=>$guildwar_p2_undefined
        ]);
    }
}
