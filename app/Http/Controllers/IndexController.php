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
use App\Invitation;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Mail\SmtpMailer;

class IndexController extends Controller
{
    public function index(){
        if(Auth::user()){
            $user = Auth::user();
            return view('index', ['user'=>$user]);
        }else{
            return redirect('login');
        }
    }

    public function account(Request $request){
        if(!Auth::user()){
            return redirect('login');
        }
        if(Auth::user()){
            $guilds = array('無與倫比', '赤焰', '夜雨花落');
            $titles = array('門派成員', '長老', '幹部','副門主', '門主');
            $guildwar_phase_1 = array('增益：鬼怪組', '丹紅城', '蓮慕城', '塞羅城','大豪城', '支援組');
            $guildwar_phase_2 = array('皇宮組', '皇城內組', '城外郊區組');
            $reasons = array('準時參加', '晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上', '無法參加本次爭奪');
            $user = User::find(Auth::user()->uid);
            return view('account', ['guilds'=>$guilds, 'titles'=>$titles, 'reasons'=>$reasons, 'user'=>$user, 'phase1'=>$guildwar_phase_1, 'phase2'=>$guildwar_phase_2]);
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
        if(!$request->filled('guild')){
            Session::flash('error_msg','請選擇所屬門派');
            return back()->withInput($request->input());
        }
        $user->gameid            = $request->filled('gameid') ? $request->gameid : '';
        $user->lineid            = $request->filled('lineid') ? $request->lineid : '';
        $user->guild             = $request->filled('guild') ? $request->guild : '';
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
            $call_leave->guild = $request->guild;
            $call_leave->reason = $request->filled('explain') ? $request->explain : '未注明';
            $call_leave->call_leave_time = time();
            $call_leave->save();
        }

        return redirect('modified_success');
    }

    public function capability(){
        if(Auth::user()){
            $user = Auth::user();
            $guild = $user->guild ? $user->guild : '無與倫比';
            $ranking = User::select('uid', 'gameid', 'lineid','guild', 'title', 'guildwar_phase_1', 'guildwar_phase_2', 'capability', 'level','thumbnail', 'roll_qty', 'approx_entry_time', 'guildwar_times')->orderBy('capability', 'DESC')->where('guild', $user->guild)->get();
            $announcement = Announcement::where([['type', 1], ['guild', $guild]])->select('content', 'last_update')->orderBy('last_update', 'DESC')->first();
            return view('capability', ['ranking'=>$ranking, 'announcement'=>$announcement, 'guild'=>$user->guild]);
        }else{
            return redirect('login');
        }  
    }

    public function contactUs(){
        return view('contact_us');
    }

    public function postContactUs(Request $request){
        Session::put('contact_sent', 'true');

        $credentials = DB::table('credentials')->select('username', 'password')->first();
        $sendTo = 'rayc9856@gmail.com';

        $capability = str_replace('萬', '0000', $request->capability);

        $body = "申請人資料:<br>電郵: $request->email<br>遊戲ID: $request->gameid<br>LineID: $request->lineid<br>戰力: " . number_format($capability) . "<br>所屬地區: $request->area<br>留言內容: $request->message";
        $mail = new Message;
        $mail->setFrom("無與倫比門派網站 <". $credentials->username . ">")
             ->addTo($sendTo)
             ->setSubject('申請邀請碼 | 加入門派請求 - 本電郵透過無與倫比網站送出，請勿回覆')
             ->setHTMLBody($body);

        $invitationCode = Invitation::find(rand(1,3))->invitation_code;
        $bodyToCandidate = '如您的電腦/行動電話未能妥善顯示本電郵全部內容，請重整您的電郵系統以便支援閱讀HTML格式的電郵
        <body style="color: #636b6f; font-family:\'Nunito\', sans-serif; font-weight:300;margin:0;">
            <div style="align-items:center;display:flex;justify-content:center;position:relative;">
                <div style="text-align:center;">
                    <img src="https://unstoppable1122.com/images/final_blade_title.png" width="50%">
                    <div style="font-size: 2em; margin-bottom: 30px;">
                        無與倫比已收到您獲取邀請碼之申請
                    </div>
                        <span style="font-size: 1.5em; font-weight:300;">請使用以下邀請碼進行注册<br>' . $invitationCode . '</span>
                    <div style="height: 30px;"></div>
                    <div>
                        <a href="https://unstoppable1122.com" style="color:#636b6f;padding:0 25px;font-size:13px;font-weight:600;letter-spacing: .1rem;text-decoration:none;text-transform: uppercase;"><i class="fas fa-home"></i> 門派首頁</a>
                    </div>
                    <div style="height: 50px;"></div>
                </div>
            </div>
            <div style="align-items:center;display:flex;justify-content:left;position:relative;">
                <div style="text-align:left;font-weight:300;">
                本電郵透過無與倫比網站送出，請勿回覆此電郵。<hr>
                上述邀請碼僅供申請人於無與倫比網站進行會員注册之用，未經無與倫比同意，申請人不得以任何形式發佈或分發上述之邀請碼。<br>
                我們實行嚴格的保安準則及程序，以防止未經授權的人取得您的個人資料。無與倫比絕對不會以電郵或其他方式要求核實個人資料，包括用戶名稱、密碼或賬戶號碼。<br> 
                此電郵提示所載的是保密資料，並可被視為享有法律特權的資料。倘若您並非指定的收件人，則不可複製、轉發、公開或使用此信息的任何部分。若此信息被誤送到您的郵箱，請刪去信息及存於您電腦內的所有相關副本。<br><br>

                經互聯網傳送的電郵信息，不保證準時、完全安全、不含錯誤或電腦病毒。寄件者不會承擔所引致任何錯誤或遺漏的責任。
                </div>
            </div>
        </body>';
        $mailToCandidate = new Message;
        $mailToCandidate->setFrom("無與倫比門派網站 <". $credentials->username . ">")
             ->addTo($request->email)
             ->setSubject('我們已收到您: 獲取邀請碼之申請 - 本電郵透過無與倫比網站送出')
             ->setHTMLBody($bodyToCandidate);

        $mailer = new SmtpMailer([
            'host' => 'smtp.gmail.com',
            'username' => $credentials->username,
            'password' => decrypt($credentials->password),
            'secure' => 'ssl',
        ]);
        $mailer->send($mail);

        // uncomment the following snippet to automatically grant invitations
        $mailer->send($mailToCandidate);
        return redirect('contact_us');
    }

    public function adminModify(){
        if(!Auth::user()->isAdmin() || !Auth::user()->guild){
            return redirect('capability');
        }
        if (Auth::user()) {
            $user = Auth::user();
        }
        $guild = $user->guild;
        $users = User::select('uid', 'gameid')->where('guild', $guild)->orderBy('capability', 'DESC')->get();
        return view('modify', ['users'=>$users]);
    }

    public function postAdminModify(Request $request){
        if(!isset($request->uid)){
            Session::flash('error_msg','請選擇成員');
            return back();
        }
        $user = User::find($request->uid);
        $guilds = array('無與倫比', '赤焰', '夜雨花落');
        $titles = array('門派成員', '長老', '幹部','副門主', '門主');
        $guildwar_phase_1 = array('增益：鬼怪組', '丹紅城', '蓮慕城', '塞羅城', '大豪城', '支援組');
        $guildwar_phase_2 = array('皇宮組', '皇城內組', '城外郊區組');
        $reasons = array('準時參加', '晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上', '無法參加本次爭奪');
        return view('modify2', ['user'=>$user, 'guilds'=>$guilds, 'titles'=>$titles, 'reasons'=>$reasons, 'phase1'=>$guildwar_phase_1, 'phase2'=>$guildwar_phase_2]);
    }

    public function postAdminConfirm(Request $request){ 
        $user = User::find($request->uid);
        $user->capability        = $request->filled('capability') ? $request->capability : 0;
        $user->level             = $request->filled('level') ? $request->level : 1;
        $user->roll_qty          = $request->filled('roll_qty') ? $request->roll_qty : 0;
        $user->guildwar_phase_1  = $request->filled('guildwar_phase_1') ? $request->guildwar_phase_1 : '';
        $user->guildwar_phase_2  = $request->filled('guildwar_phase_2') ? $request->guildwar_phase_2 : '';
        $user->title             = $request->filled('title') ? $request->title : '';
        $user->guild             = $request->filled('guild') ? $request->guild : '';
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
        if(!Auth::user()->isAdmin()){
            return redirect('capability');
        }
        return view('announcement');
    }

    public function postEditAnnouncement(Request $request){
        if(!isset($request->type)){
            Session::flash('error_msg','請選擇文章類別');
            return back()->withInput($request->input());
        }

        $author = Auth::user()->lineid;

        $announcement = new Announcement();
        $announcement->type = $request->type;
        $announcement->uid  = Auth::user()->uid;
        $announcement->guild  = Auth::user()->guild;
        $announcement->content = strip_tags(str_replace(["\r\n", "\n", "\r"], '<br>', $request->content), '<p><a><b><br>');
        $announcement->updated_by = $author;
        $announcement->last_update = time();
        $announcement->save();

        return redirect('updated_success');
    }

    public function flyer(){
        return view('flyer');
    }

    public function relativeLinks(){
        return view('relative_links');
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
