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
        $users = User::select('uid', 'gameid')->where('guild','無與倫比')->get();
        return view('guildwar_data', ['users'=>$users]);
    }

    public function postGuildwarData(Request $request){
        if(!$request->filled('uid')){
            Session::flash('error_msg','請選擇遊戲ID');
            return back()->withInput($request->input());
        }
        $gameid = User::find($request->uid)->value('gameid');

        $record = new Guildwar();
        $record->uid           = $request->uid;
        $record->gameid        = $gameid;
        $record->rank          = $request->filled('rank') ? $request->rank : 0;
        $record->attack_times  = $request->filled('attack_times') ? $request->attack_times : 0;
        $record->contribution  = $request->filled('contribution') ? $request->contribution : 0;
        $record->reward        = $request->filled('reward') ? $request->reward : 0;
        $record->guildwar_date = $request->guildwar_date;

        $record->save();

        // update users.guildwar_times and users.roll_qty
        $user = User::find($request->uid);
        $old_value = $user->guildwar_times;
        $new_value = $old_value + $request->attack_times;

        if($user->roll_qty > $request->attack_times){
            $new_roll_qty = $user->roll_qty - $request->attack_times;
        }else{
            $new_roll_qty = 0;
        }

        $user->update(['guildwar_times'=>$new_value, 'roll_qty'=>$new_roll_qty]);

        Session::flash('success_msg', '已成功錄入: ' . $gameid);
        return redirect('insert_success');
    }

    public function insertSuccess(){
        return view('insert_success');
    }

    public function guildwarDataList(){
        if(!Auth::user()){
            return redirect('login');
        }
        $data = Guildwar::where(['is_delete', '<>', 1], ['guild','無與倫比'])->orderBy('guildwar_date','DESC')->orderBy('rank','ASC')->get();
        return view('guildwar_data_list', ['records'=>$data]);
    }

    public function raiseDeleteFlag($record_id){
        if(!Auth::user()->isAdmin() || !isset($record_id)){
            return redirect('guildwar_data_list');
        }
        $record = Guildwar::find($record_id);
        $uid = $record->uid;

        $user = User::find($uid);
        $value_to_deduct = $record->attack_times;
        $current_guildwar_value = $user->guildwar_times;

        if($current_guildwar_value > $value_to_deduct){
            $new_guildwar_value = $current_guildwar_value - $value_to_deduct;
        }else{
            $new_guildwar_value = 0;
        }

        $new_roll_qty = $user->roll_qty + $value_to_deduct;

        $record->is_delete = 1;
        $record->save();

        $user->guildwar_times = $new_guildwar_value;
        $user->roll_qty = $new_roll_qty;

        $user->save();
        return redirect('guildwar_data_list');
    }

    public function analysisAll(){
        // OnTime Count
        $tanhungTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '丹紅城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
        $linmoTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '蓮慕城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
        $choiloTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '塞羅城'], ['approx_entry_time', '準時參加']])->count();
        $taihoTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '大豪城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
        $buffTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
        /*
         * Team List
         * 
         */
        // Choi Lo
        $choiloTeamLateCount = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '塞羅城']])->count();
        $choiloTeamLate = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '塞羅城']])->get();
        $choiloTeamLateList = '';
        foreach ($choiloTeamLate as $choiloLateMember) {
            $choiloTeamLateList .= "{$choiloLateMember->lineid} | ";
        }
        $choiloTeamLateList = rtrim($choiloTeamLateList, ' | ');

        $choiloTeamLeave = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '塞羅城']])->get();
        $choiloTeamLeaveCount = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '塞羅城']])->count();
        $choiloTeamLeaveList = '';
        foreach ($choiloTeamLeave as $choiloLeaveMember) {
            $choiloTeamLeaveList .= "{$choiloLeaveMember->lineid} | ";
        }
        $choiloTeamLeaveList = rtrim($choiloTeamLeaveList, ' | ');

        // Tai Ho
        $taihoTeamLateCount = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '大豪城']])->count();
        $taihoTeamLate = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '大豪城']])->get();
        $taihoTeamLateList = '';
        foreach ($taihoTeamLate as $taihoLateMember) {
            $taihoTeamLateList .= "{$taihoLateMember->lineid} | ";
        }
        $taihoTeamLateList = rtrim($taihoTeamLateList, ' | ');

        $taihoTeamLeave = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '大豪城']])->get();
        $taihoTeamLeaveCount = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '大豪城']])->count();
        $taihoTeamLeaveList = '';
        foreach ($taihoTeamLeave as $taihoLeaveMember) {
            $taihoTeamLeaveList .= "{$taihoLeaveMember->lineid} | ";
        }
        $taihoTeamLeaveList = rtrim($taihoTeamLeaveList, ' | ');
        
        // Buff
        $buffTeamLateCount = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組']])->count();
        $buffTeamLate = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組']])->get();
        $buffTeamLateList = '';
        foreach ($buffTeamLate as $buffLateMember) {
            $buffTeamLateList .= "{$buffLateMember->lineid} | ";
        }
        $buffTeamLateList = rtrim($buffTeamLateList, ' | ');

        $buffTeamLeave = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組']])->get();
        $buffTeamLeaveCount = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組']])->count();
        $buffTeamLeaveList = '';
        foreach ($buffTeamLeave as $buffLeaveMember) {
            $buffTeamLeaveList .= "{$buffLeaveMember->lineid} | ";
        }
        $buffTeamLeaveList = rtrim($buffTeamLeaveList, ' | ');

        $total_users = User::where('guild', '無與倫比')->count();

        $approx_case_1 = User::where([['guild','無與倫比'],['approx_entry_time','準時參加']])->get();

        $approx_case_2 = User::where([['guild','無與倫比'],['approx_entry_time','晚到10分鐘']])->get();

        $approx_case_3 = User::where([['guild','無與倫比'],['approx_entry_time','晚到11~20分鐘']])->get();

        $approx_case_4 = User::where([['guild','無與倫比'],['approx_entry_time','晚到30分鐘以上']])->get();

        $approx_case_5 = User::where([['guild','無與倫比'],['approx_entry_time','無法參加本次爭奪']])->get();

        $approx_case_6 = User::where([['guild','無與倫比'],['approx_entry_time', '']])->get();

        $guildwar_p1 = User::where([['guild','無與倫比'],['guildwar_phase_1', '<>', '']])->get();

        $guildwar_p1_buff = User::where([['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組']])->get();

        $guildwar_p1_tanhung = User::where([['guild','無與倫比'],['guildwar_phase_1', '丹紅城']])->get();

        $guildwar_p1_taiho = User::where([['guild','無與倫比'],['guildwar_phase_1', '大豪城']])->get();

        $guildwar_p1_linmo = User::where([['guild','無與倫比'],['guildwar_phase_1', '蓮慕城']])->get();

        $guildwar_p1_choilo = User::where([['guild','無與倫比'],['guildwar_phase_1', '塞羅城']])->get();

        $guildwar_p1_undefined = User::where([['guild','無與倫比'],['guildwar_phase_1', '']])->get();

        $guildwar_p2 = User::where([['guild','無與倫比'],['guildwar_phase_2', '<>', '']])->get();

        $guildwar_p2_urban = User::where([['guild','無與倫比'],['guildwar_phase_2', '城外郊區組']])->get();

        $guildwar_p2_forbidden = User::where([['guild','無與倫比'],['guildwar_phase_2', '皇城內組']])->get();

        $guildwar_p2_palace = User::where([['guild','無與倫比'],['guildwar_phase_2', '皇宮組']])->get();

        $guildwar_p2_undefined = User::where([['guild','無與倫比'],['guildwar_phase_2', '']])->get();

        return view('analysis', ['total_users'=>$total_users,
                                'ontime'=>$approx_case_1,
                                'approx_case_2'=>$approx_case_2,
                                'approx_case_3'=>$approx_case_3,
                                'approx_case_4'=>$approx_case_4,
                                'absent'=>$approx_case_5,
                                'approx_undefined'=>$approx_case_6,
                                'guildwar_p1_registered'=>$guildwar_p1,
                                'guildwar_p1_buff'=>$guildwar_p1_buff,
                                'tanhung'=>$guildwar_p1_tanhung,
                                'linmo'=>$guildwar_p1_linmo,
                                'choilo'=>$guildwar_p1_choilo,
                                'taiho'=>$guildwar_p1_taiho,
                                'guildwar_p1_undefined'=>$guildwar_p1_undefined,
                                'guildwar_p2_registered'=>$guildwar_p2,
                                'guildwar_p2_urban'=>$guildwar_p2_urban,
                                'guildwar_p2_forbidden'=>$guildwar_p2_forbidden,
                                'guildwar_p2_palace'=>$guildwar_p2_palace,
                                'guildwar_p2_undefined'=>$guildwar_p2_undefined,
                                'tanhungTeamCount'=>$tanhungTeamCount,
                                'linmoTeamCount'=>$linmoTeamCount,
                                'choiloTeamCount'=>$choiloTeamCount,
                                'taihoTeamCount'=>$taihoTeamCount,
                                'buffTeamCount'=>$buffTeamCount,
                                'choiloTeamLateCount'=>$choiloTeamLateCount,
                                'choiloTeamLateList'=>$choiloTeamLateList,
                                'choiloTeamLeaveCount'=>$choiloTeamLeaveCount,
                                'choiloTeamLeaveList'=>$choiloTeamLeaveList,
                                'taihoTeamLateCount'=>$taihoTeamLateCount,
                                'taihoTeamLateList'=>$taihoTeamLateList,
                                'taihoTeamLeaveCount'=>$taihoTeamLeaveCount,
                                'taihoTeamLeaveList'=>$taihoTeamLeaveList,
                                'buffTeamLateCount'=>$buffTeamLateCount,
                                'buffTeamLateList'=>$buffTeamLateList,
                                'buffTeamLeaveCount'=>$buffTeamLeaveCount,
                                'buffTeamLeaveList'=>$buffTeamLeaveList
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
}
