<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use App\User;

class IndexController extends Controller
{
    public function index(){
        if(Auth::user()){
            $name = DB::table('users')->select('lineid')->where('uid', Auth::user()->uid)->value('lineid');
            return view('index', ['name'=>$name]);
        }else{
            return redirect('login');
        }
    }

    public function account(){
        if(Auth::user()){
            $titles = array('門派成員', '長老', '幹部','副門主', '門主');
            $guildwar_phase_1 = array('增益：鬼怪組', '大豪城', '蓮慕城', '賽羅城');
            $guildwar_phase_2 = array('皇宮組', '皇城內組', '城外郊區組');
            $reasons = array('準時參加', '晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上', '無法參加本次爭奪');
            $user = DB::table('users')->select('uid','email', 'gameid', 'lineid', 'title', 'guildwar_phase_1', 'guildwar_phase_2', 'approx_entry_time', 'level', 'capability', 'roll_qty', 'last_update')->where('uid', Auth::user()->uid)->first();
            // $approx = $user->approx_entry_time;
            return view('account', ['titles'=>$titles, 'reasons'=>$reasons, 'user'=>$user, 'phase1'=>$guildwar_phase_1, 'phase2'=>$guildwar_phase_2]);
        }else{
            return redirect('login');
        } 
    }

    public function postAccount(Request $request){
        $user = Auth::user();
        if($request->pwd != $request->confirm_pwd){
            Session::flash('error_msg','密碼與確認密碼不一致, 請重新輸入');
            return back()->withInput();
        }
        if($request->pwd == $request->confirm_pwd && !empty($request->pwd)){
            $user->password = bcrypt($request->pwd);
        }       
        $user->uid               = $request->uid;
        $user->gameid            = $request->gameid;
        $user->lineid            = $request->lineid;
        $user->title             = $request->title;
        $user->approx_entry_time = $request->reason;
        $user->level             = $request->level;
        $user->capability        = $request->capability;
        $user->roll_qty          = $request->roll_qty;
        $user->guildwar_phase_1  = $request->guildwar_phase_1;
        $user->guildwar_phase_2  = $request->guildwar_phase_2;
        $user->last_update       = time();
        $user->save();

        return redirect('modified_success');
    }

    public function capability(){
        $ranking = DB::table('users')->select('uid', 'gameid', 'lineid', 'title', 'guildwar_phase_1', 'guildwar_phase_2', 'capability', 'level','thumbnail', 'approx_entry_time', 'guildwar_times')->orderBy('capability', 'DESC')->get();
        // $userinfo = DB::table('users')->select('uid')->where('email', 'rayc9223@gmail.com')->value('uid');
        return view('capability', ['ranking'=>$ranking]);

            // $table->increments('uid');
            // $table->string('gameid',40)->default('');
            // $table->string('lineid',40)->default('');
            // $table->string('title',20)->default('');
            // $table->string('thumbnail')->default('');
            // $table->string('team_line_up')->default('');
            // $table->string('approx_entry_time',20)->nullable();
            // $table->tinyInteger('level')->default(1);
            // $table->integer('capability')->default(0);
            // $table->integer('roll_qty')->default(0);
            // $table->integer('guildwar_times')->default(0);
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->timestamp('last_update')->nullable();
            // $table->string('password');
            // $table->rememberToken();
            // $table->timestamps();


    }

    public function announce(){
        return view('announce');
    }

    public function guildwar(){
        return view('guildwar');
    }

    public function comment(){
        return view('comment');
    }

    public function modifiedSuccess(){
        return view('modified_success');
    }
}
