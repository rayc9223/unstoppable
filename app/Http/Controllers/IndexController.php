<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Config;
use DB;
use Session;
use App\User;
use App\Leave;
use App\Announcement;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Mail\SmtpMailer;

class IndexController extends Controller
{
    public function index(){
        // var_dump(Auth::user());exit;
        if(Auth::user()){
            $name = User::find(Auth::user()->uid)->value('lineid');
            Session::put('welcome', $name);
            return view('index');
        }else{
            return redirect('login');
        }
    }

    public function account(Request $request){
        if(!Auth::user()){
            return redirect('login');
        }
        if(Auth::user()){
            $titles = array('門派成員', '長老', '幹部','副門主', '門主');
            $guildwar_phase_1 = array('增益：鬼怪組', '大豪城', '蓮慕城', '塞羅城', '支援組');
            $guildwar_phase_2 = array('皇宮組', '皇城內組', '城外郊區組');
            $reasons = array('準時參加', '晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上', '無法參加本次爭奪');
            $user = User::find(Auth::user()->uid);
            return view('account', ['titles'=>$titles, 'reasons'=>$reasons, 'user'=>$user, 'phase1'=>$guildwar_phase_1, 'phase2'=>$guildwar_phase_2]);
        }else{
            return redirect('login');
        } 
    }

    public function postAccount(Request $request){
        if(Auth::user()->uid != $request->uid){
            return redirect('index');
        }
        $user = User::find($request->uid);
        // $user = DB::table('users')->where('uid', $request->uid)->first();
        if($request->pwd != $request->confirm_pwd){
            Session::flash('error_msg','密碼與確認密碼不一致, 請重新輸入');
            return back()->withInput($request->input());
        }
        if($request->pwd == $request->confirm_pwd && !empty($request->pwd)){
            $user->password = bcrypt($request->pwd);
        }
        if(!$request->filled('gameid') || !$request->filled('lineid')){
            Session::flash('error_msg','請填寫遊戲ID及LINE-ID');
            return back()->withInput($request->input());
        }
        $user->gameid            = $request->filled('gameid') ? $request->gameid : '';
        $user->lineid            = $request->filled('lineid') ? $request->lineid : '';
        $user->title             = $request->filled('title') ? $request->title : '';
        $user->approx_entry_time = $request->filled('reason') ? $request->reason : '';
        $user->level             = $request->filled('level') ? $request->level : 1;
        $user->capability        = $request->filled('capability') ? $request->capability : 0;
        $user->roll_qty          = $request->filled('roll_qty') ? $request->roll_qty : 0;
        $user->guildwar_phase_1  = $request->filled('guildwar_phase_1') ? $request->guildwar_phase_1 : '';
        $user->guildwar_phase_2  = $request->filled('guildwar_phase_2') ? $request->guildwar_phase_2 : '';
        $user->last_update       = time();
        $user->save();

        if($request->reason == '無法參加本次爭奪'){
            $call_leave = new Leave();
            $call_leave->uid = $request->uid;
            $call_leave->gameid = $request->gameid;
            $call_leave->reason = $request->filled('explain') ? $request->explain : '未注明';
            $call_leave->call_leave_time = time();
            $call_leave->save();
        }

        return redirect('modified_success');
    }

    public function capability(){
        $ranking = User::select('uid', 'gameid', 'lineid', 'title', 'guildwar_phase_1', 'guildwar_phase_2', 'capability', 'level','thumbnail', 'roll_qty', 'approx_entry_time', 'guildwar_times')->orderBy('capability', 'DESC')->get();
        $announcement = Announcement::where('type', 1)->select('content', 'last_update')->orderBy('last_update', 'DESC')->first();
        return view('capability', ['ranking'=>$ranking, 'announcement'=>$announcement]);
    }

    public function contactUs(){
        return view('contact_us');
    }

    public function postContactUs(Request $request){
        Session::put('contact_sent', 'true');

        $credentials = DB::table('credentials')->select('username', 'password')->first();
        $sendTo = 'icheng0117@gmail.com';

        $body = "申請人資料:<br>電郵: $request->email<br>遊戲ID: $request->gameid<br>LineID: $request->lineid<br>戰力: number_format($request->capability)<br>所屬地區: $request->area<br>留言內容: $request->message";
        $mail = new Message;
        $mail->setFrom("無與倫比門派網站 <". $credentials->username . ">")
             ->addTo($sendTo)
             ->setSubject('申請邀請碼 | 加入門派請求 - 本電郵透過無與倫比網站送出，請勿回覆')
             ->setHTMLBody($body);

        $mailer = new SmtpMailer([
            'host' => 'smtp.gmail.com',
            'username' => $credentials->username,
            'password' => decrypt($credentials->password),
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

    public function adminModify(){
        if(!Auth::user()->isAdmin()){
            return redirect('capability');
        }
        $users = User::select('uid', 'gameid')->orderBy('capability', 'DESC')->get();
        return view('modify', ['users'=>$users]);
    }

    public function postAdminModify(Request $request){
        if(!isset($request->uid)){
            Session::flash('error_msg','請選擇成員');
            return back();
        }
        $user = User::find($request->uid);
        $titles = array('門派成員', '長老', '幹部','副門主', '門主');
        $guildwar_phase_1 = array('增益：鬼怪組', '大豪城', '蓮慕城', '塞羅城', '支援組');
        $guildwar_phase_2 = array('皇宮組', '皇城內組', '城外郊區組');
        $reasons = array('準時參加', '晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上', '無法參加本次爭奪');
        return view('modify2', ['user'=>$user, 'titles'=>$titles, 'reasons'=>$reasons, 'phase1'=>$guildwar_phase_1, 'phase2'=>$guildwar_phase_2]);
    }

    public function postAdminConfirm(Request $request){ 
        $user = User::find($request->uid);
        $user->capability = $request->filled('capability') ? $request->capability : 0;
        $user->level = $request->filled('level') ? $request->level : 1;
        $user->roll_qty = $request->filled('roll_qty') ? $request->roll_qty : 0;
        $user->guildwar_phase_1 = $request->filled('guildwar_phase_1') ? $request->guildwar_phase_1 : '';
        $user->guildwar_phase_2 = $request->filled('guildwar_phase_2') ? $request->guildwar_phase_2 : '';
        $user->title = $request->filled('title') ? $request->title : '';
        $user->approx_entry_time = $request->filled('reason') ? $request->reason : '';
        $user->save();

        if($request->reason == '無法參加本次爭奪'){
            $call_leave = new Leave();
            $call_leave->uid = $request->uid;
            $call_leave->gameid = $request->gameid;
            $call_leave->reason = isset($request->explain)? $request->explain : '未注明';
            $call_leave->call_leave_time = time();
            $call_leave->save();
        }

        return redirect('admin_modified_success');
    }

    public function adminModifiedSuccess(){
        return view('admin_modified_success');
    }

    public function editAnnouncement(){
        if(!Auth::user()->isAdmin){
            return redirect('capability');
        }
        return view('announcement');
    }

    public function postEditAnnouncement(Request $request){
        if(!isset($request->type)){
            Session::flash('error_msg','請選擇文章類別');
            return back()->withInput($request->input());
        }

        $author = User::find(Auth::user()->uid)->value('lineid');

        $announcement = new Announcement();
        $announcement->type = $request->type;
        $announcement->uid  = Auth::user()->uid;
        $announcement->content = strip_tags(str_replace(["\r\n", "\n", "\r"], '<br>', $request->content), '<p><a><b><br>');
        $announcement->updated_by = $author;
        $announcement->last_update = time();
        $announcement->save();

        return redirect('updated_success');
    }

    public function updateSuccess(){
        return view('updated_success');
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
