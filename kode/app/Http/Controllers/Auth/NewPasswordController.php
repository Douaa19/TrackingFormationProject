<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordReset;
use App\Models\User;
use App\Http\Utility\SendMail;
use Carbon\Carbon;

class NewPasswordController extends Controller
{
    public function create(int | string $token)
    {
        $title = "Password change";
        $passwordToken = $token;
        $email = session()->get('password_reset_user_email');
        $userResetToken = PasswordReset::where('email', $email)->where('token', $token)->first();
        if(!$userResetToken){
            return redirect(route('password.request'))->with('error',translate('Invalid token'));
        }
        return view('user.auth.reset',compact('title', 'passwordToken'));
    }

    public function store(Request $request) :\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'token' => 'required|exists:password_resets,token',
        ],[
            "password.required" => translate("Password Field Is Required"),
            "password.confirmed" => translate("Confirm Password Does Not Match With Password"),
            "token.required" => translate("Token Is Required"),
            "token.exists" => translate("Invalid Token"),
        ]);
        $email = session()->get('password_reset_user_email');
        $userResetToken = PasswordReset::where('email', $email)->where('token', $request->token)->first();
        if(!$userResetToken){
            return redirect(route('password.request'))->with('error',translate('Invalid token'));
        }
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        if(session()->get('password_reset_user_email')){
            session()->forget('password_reset_user_email');
        }
        $mailCode = [
            'time' => Carbon::now(),
            'code' => $userResetToken->token,
        ];
        SendMail::MailNotification($user,'PASSWORD_RESET_CONFIRM',$mailCode);
        $userResetToken->delete();
        return redirect(route('login'))->with('success',translate('Password changed successfully'));
    }
}
