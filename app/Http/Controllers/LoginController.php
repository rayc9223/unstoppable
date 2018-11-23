<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;
use Nette\Mail\SmtpMailer;

class LoginController extends Controller
{
    public function memberLogin(){
        return view('login');
    }

    public function postLogin(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $uid = DB::table('users')->select('uid')->where('email', $request->email)->value('uid');
            Session::put('uid', $uid);
            return redirect()->intended('index');
        }else{
            Session::flash('error_msg','電郵地址或密碼錯誤，請確認後重新輸入');
            return back()->withInput($request->input());
        }
    }

    public function logout(){
        Session::flush();
        return view('welcome');
    }

    public function forgot(){
        return view('forgot');
    }

    public function postForgot(Request $request){
        $email = $request->email;
        $validate = DB::table('users')->where('email', $email)->first();
        if(!$validate){
            Session::flash('error_msg','電郵地址錯誤，請確認後重新輸入');
            return back()->withInput($request->input());
        }else{
            $token = $this->genToken(18);
            Session::put('reset_password_token', $token);
            $body = "請透過以下連結重置密碼<br>" . url('reset_password') . '?email=' . $email .'&token=' . $token;
            $mail = new Message;
            $mail->setFrom('無與倫比門派網站 <rayc9223@gmail.com>')
                 ->addTo($email)
                 ->setSubject('重置密碼電郵 - 無與倫比')
                 ->setHTMLBody($body);

            $mailer = new SmtpMailer([
                'host' => 'smtp.gmail.com',
                'username' => 'rayc9223@gmail.com',
                'password' => 'Edi55009@',
                'secure' => 'ssl',
                // 'context' =>  [
                //     'ssl' => [
                //         'capath' => '/path/to/my/trusted/ca/folder',
                //      ],
                // ],
            ]);
            $mailer->send($mail);

            Session::flash('success_msg','密碼重置電郵已成功送出');
            return redirect('forgot');
        }
    }

    public function resetPassword(Request $request){
        if($request->token == Session::get('reset_password_token')){
            return view('reset_password');
        }else{
            return redirect('login');
        }
    }

    public function postResetPassword(Request $request){
        if($request->email && $request->password == $request->confirm_password){
            $password = bcrypt($request->password);
            $user = DB::table('users')->where('email', $request->email)->update(['password'=>$password]);

            Session::forget('reset_password_token');

            return redirect('reset_password_success');
        }
    }

    public function resetPasswordSuccess(){
        return view('reset_password_success');
    }

    public function genToken(int $length){
        $seed = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $result = '';
        for ($i=0; $i < $length; $i++) { 
            $result .= substr($seed, mt_rand(0,strlen($seed)-1),1);
        }
        return $result;
    }
}
