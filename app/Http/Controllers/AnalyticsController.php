<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Guildwar;
use Auth;
use DB;
use Session;
use App\Libraries\Helpers;

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
        $data = Guildwar::where([['is_delete', '<>', 1], ['guild','無與倫比']])->orderBy('guildwar_date','DESC')->orderBy('rank','ASC')->get();
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

    public function analysisAll(Helpers $helpers){
        // Get Team Data
        $tanHung = $helpers->getTeamData('丹紅城');
        $linMo = $helpers->getTeamData('蓮慕城');
        $choiLo = $helpers->getTeamData('塞羅城');
        $taiHo = $helpers->getTeamData('大豪城');
        $buff = $helpers->getTeamData('增益：鬼怪組');

        $analysisData = $helpers->analysis();

        return view('analysis',['data'=>$analysisData,
                                'tanhung'=>$tanHung,
                                'linmo'=>$linMo,
                                'choilo'=>$choiLo,
                                'taiho'=>$taiHo,
                                'buff'=>$buff
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
