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
        if(!Auth::user()->isAdmin()){
            return redirect('index');
        }
        $users = User::select('uid', 'gameid')->get();
        return view('guildwar_data', ['users'=>$users]);
    }

    public function postGuildwarData(Request $request){
        $gameid = User::where('uid',$request->uid)->value('gameid');

        $user = new Guildwar();
        $user->uid           = $request->uid;
        $user->gameid        = $gameid;
        $user->rank          = $request->filled('rank') ? $request->rank : 0;
        $user->attack_times  = $request->filled('attack_times') ? $request->attack_times : 0;
        $user->contribution  = $request->filled('contribution') ? $request->contribution : 0;
        $user->reward        = $request->filled('reward') ? $request->reward : 0;
        $user->guildwar_date = $request->guildwar_date;

        $user->save();

        // update users.guildwar_times
        $old_value = User::find($request->uid)->value('guildwar_times');
        $new_value = $old_value + $request->attack_times;

        User::find($request->uid)->update(['guildwar_times'=>$new_value]);

        Session::flash('success_msg', '已成功錄入: ' . $gameid);
        return redirect('insert_success');
    }

    public function insertSuccess(){
        return view('insert_success');
    }

    public function guildwarDataList(){
        $data = Guildwar::where('is_delete', '<>', 1)->orderBy('guildwar_date','DESC')->orderBy('rank','ASC')->get();
        return view('guildwar_data_list', ['records'=>$data]);
    }

    public function toggleDeleteFlag(Request $request){
        $record_id = $request->id;
        $record = Guildwar::find($record_id);
        $record->is_delete = 1;
        $record->save();
    }

    public function analysisAll(){
        $total_users = User::count();

        $highest_roll_qty = User::max('roll_qty');

        $lowest_roll_qty = User::min('roll_qty');

        $approx_case_1 = User::where('approx_entry_time', '準時參加')->get();

        $approx_case_2 = User::where('approx_entry_time', '晚到10分鐘')->get();

        $approx_case_3 = User::where('approx_entry_time', '晚到11~20分鐘')->get();

        $approx_case_4 = User::where('approx_entry_time', '晚到30分鐘以上')->get();

        $approx_case_5 = User::where('approx_entry_time', '無法參加本次爭奪')->get();

        $approx_case_6 = User::where('approx_entry_time', '')->get();

        $guildwar_p1 = User::where('guildwar_phase_1','<>', '')->get();

        $guildwar_p1_buff = User::where('guildwar_phase_1', '增益：鬼怪組')->get();

        $guildwar_p1_taiho = User::where('guildwar_phase_1', '大豪城')->get();

        $guildwar_p1_linmo = User::where('guildwar_phase_1', '蓮慕城')->get();

        $guildwar_p1_choilo = User::where('guildwar_phase_1', '塞羅城')->get();

        $guildwar_p1_undefined = User::where('guildwar_phase_1', '')->get();

        $guildwar_p2 = User::where('guildwar_phase_2','<>', '')->get();

        $guildwar_p2_urban = User::where('guildwar_phase_2', '城外郊區組')->get();

        $guildwar_p2_forbidden = User::where('guildwar_phase_2', '皇城內組')->get();

        $guildwar_p2_palace = User::where('guildwar_phase_2', '皇宮組')->get();

        $guildwar_p2_undefined = User::where('guildwar_phase_2', '')->get();

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

    public function confirmReset(Request $request){
        // $pass_uid = $request->get('uid');
        // $auth_uid = Auth::user()->uid;
        $verify = Auth::user()->isAdmin();
        if($verify){
            $users = User::get();
            foreach ($users as $user) {
                $user->update(['approx_entry_time'=>'']);
            }
        }else{
            return redirect('capability');
        }
        return redirect('reset_success');
    }

    public function resetSuccess(){
        return view('reset_success');
    }

    // TEST METHOD - DO NOT UNCOMMENT !!

    // public function updateUserGuildwarTimes(){
    //     $users = DB::table('guildwars')->select('uid', 'attack_times')->get();

    //     foreach($users as $record){
    //         $modify = User::find($record->uid);
    //         $modify->guildwar_times = $record->attack_times;
    //         $modify->save();
    //         echo $modify->gameid, '-', $record->attack_times,'<br>';  
    //     }
    // }
}
