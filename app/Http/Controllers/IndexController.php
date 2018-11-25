<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Config;
use DB;
use Session;
use App\User;
use App\Leave;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Mail\SmtpMailer;

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

    public function account(Request $request){
        if(Auth::user()->uid != $request->uid){
            return redirect('index');
        }
        if(Auth::user()){
            $titles = array('門派成員', '長老', '幹部','副門主', '門主');
            $guildwar_phase_1 = array('增益：鬼怪組', '大豪城', '蓮慕城', '塞羅城');
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
        $user = User::find($request->uid);
        // $user = DB::table('users')->where('uid', $request->uid)->first();
        if($request->pwd != $request->confirm_pwd){
            Session::flash('error_msg','密碼與確認密碼不一致, 請重新輸入');
            return back()->withInput();
        }
        if($request->pwd == $request->confirm_pwd && !empty($request->pwd)){
            $user->password = bcrypt($request->pwd);
        }       
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

        if($request->reason == '無法參加本次爭奪'){
            $call_leave = new Leave();
            $call_leave->uid = $request->uid;
            $call_leave->gameid = $request->gameid;
            $call_leave->reason = isset($request->explain)? $request->explain : '未注明';
            $call_leave->call_leave_time = time();
            $call_leave->save();
        }

        return redirect('modified_success');
    }

    public function capability(){
        $ranking = DB::table('users')->select('uid', 'gameid', 'lineid', 'title', 'guildwar_phase_1', 'guildwar_phase_2', 'capability', 'level','thumbnail', 'roll_qty', 'approx_entry_time', 'guildwar_times')->orderBy('capability', 'DESC')->get();
        // $userinfo = DB::table('users')->select('uid')->where('email', 'rayc9223@gmail.com')->value('uid');
        return view('capability', ['ranking'=>$ranking]);
    }

    public function contactUs(){
        return view('contact_us');
    }

    public function postContactUs(Request $request){
        Session::put('contact_sent', 'true');

        $sendTo = 'rayc9223@gmail.com';

        $body = "申請人資料:<br>電郵: $request->email<br>遊戲ID: $request->gameid<br>LineID: $request->lineid<br>戰力: number_format($request->capability)<br>所屬地區: $request->area<br>留言內容: $request->message";
        $mail = new Message;
        $mail->setFrom("無與倫比門派網站 <". Config::get('my_smtp.sender') . ">")
             ->addTo($sendTo)
             ->setSubject('申請邀請碼 | 加入門派請求 - 本電郵透過無與倫比網站送出，請勿回覆')
             ->setHTMLBody($body);

        $mailer = new SmtpMailer([
            'host' => 'smtp.gmail.com',
            'username' => Config::get('my_smtp.sender'),
            'password' => Config::get('my_smtp.pwd'),
            'secure' => 'ssl',
            // 'context' =>  [
            //     'ssl' => [
            //         'capath' => '/path/to/my/trusted/ca/folder',
            //      ],
            // ],
        ]);
        $mailer->send($mail);
        return redirect('contact_us');
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
