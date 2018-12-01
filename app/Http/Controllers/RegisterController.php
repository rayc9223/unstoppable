<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use App\User;

class RegisterController extends Controller
{
    public function register(){
        return view('register');
    }

    public function registerSuccess(){
        return view('register_success');
    }

    public function postRegister(Request $request){
        $email = User::where('email', $request->email)->first();
        if($email){
            Session::flash('error_msg','此電郵地址已被使用');
            return back()->withInput($request->input());
        }
        if($request->pwd!=$request->confirm_pwd){
            Session::flash('error_msg','密碼與確認密碼不一致, 請重新輸入');
            return back()->withInput();
        }elseif($request->invitation_code=='2z9L0YnSN6pu409WEt' || $request->invitation_code=='6SvFGsNU4VgKBaFFPu' || $request->invitation_code=='fNvQJ46GBcPnGkIT2C'){

        /* invitation_code

        2z9L0YnSN6pu409WEt

        6SvFGsNU4VgKBaFFPu

        fNvQJ46GBcPnGkIT2C

        */
        
        $user = new User();
        $user->gameid = $request->gameid;
        $user->lineid = $request->lineid;
        $user->email = $request->email;
        $user->password = bcrypt($request->pwd);
        $user->save();

        $uid = DB::table('users')->select('uid')->where('email', $request->email)->value('uid');
        Session::put('uid', $uid);

        Auth::attempt(['email'=>$request->email, 'password'=>$request->pwd]);

        return redirect('register_success');
            
        }else{
            Session::flash('error_msg','邀請碼錯誤, 請重新確認');
            return back()->withInput($request->input());
        }

        
    }
}
