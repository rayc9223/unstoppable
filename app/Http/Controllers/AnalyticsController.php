<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Guildwar;
use Auth;
use DB;
use Session;

class AnalyticsController extends Controller
{
    public function guildwarData(){
        $users = DB::table('users')->select('uid', 'gameid')->get();
        return view('guildwar_data', ['users'=>$users]);
    }

    public function postGuildwarData(Request $request){
        if(!in_array(Auth::user()->uid, array(1,2,3,10,12,13,27))){
            return redirect('index');
        }
        $gameid = User::find($request->uid)->value('gameid');
        echo $gameid;
        dd($request->all());
        // $user = User::find($request->uid);
        $user = new Guildwar();
        $user->uid           = $request->uid;
        $user->gameid        = $gameid;
        $user->rank          = $request->rank;
        $user->attack_times  = $request->attack_times;
        $user->contribution  = $request->contribution;
        $user->reward        = $request->reward;
        $user->guildwar_date = $request->guildwar_date;

        $user->save();

        Session::flash('success_msg', '已成功錄入: ' . $gameid);
        return redirect('insert_success');
    }

    public function insertSuccess(){
        return view('insert_success');
    }

    public function guildwarDataList(){
        $data = DB::table('guildwars')->orderBy('guildwar_date','DESC')->orderBy('rank','ASC')->get();
        return view('guildwar_data_list', ['records'=>$data]);
    }

    public function toggleDeleteFlag(Request $request){
        $record_id = $request->id;
        $record = Guildwar::find($record_id);
        $record->is_delete = 1;
        $record->save();
    }

    public function analysisAll(){
        $total_users = DB::table('users')->count();

        $highest_roll_qty = DB::table('users')->max('roll_qty');

        $lowest_roll_qty = DB::table('users')->min('roll_qty');

        $approx_case_1 = DB::table('users')->where('approx_entry_time', '準時參加')->get();

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
