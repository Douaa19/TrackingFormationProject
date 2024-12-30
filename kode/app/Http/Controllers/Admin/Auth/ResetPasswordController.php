<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminPasswordReset;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Utility\SendMail;
use Illuminate\Http\RedirectResponse;
class ResetPasswordController extends Controller
{
    public function create(Request $request, int | string $token)
    {
        $title          = "Password change";
        $passwordToken  = $token;
        $email          = session()->get('admin_password_reset_user_email');
        $userResetToken = AdminPasswordReset::where('email', $email)->where('token', $token)->first();
        if(!$userResetToken){
        	if(session()->get('admin_password_reset_user_email')){
	            session()->forget('admin_password_reset_user_email');
	        }
            return redirect(route('admin.password.request'))->with('error',translate('Invalid token'));
        }
        return view('admin.auth.reset',compact('title', 'passwordToken'));
    }

    public function store(Request $request) :RedirectResponse
    {
        $request->validate([
            'password'            => 'required|confirmed|min:4',
            'token'               => 'required|exists:admin_password_resets,token',
        ],[
            "password.required"   => translate("Password Field Is Required"),
            "password.confirmed"  => translate("Confirm Password Does Not Match With Password"),
            "token.required"      => translate("Token Is Required"),
            "token.exists"        => translate("Invalid Token"),
        ]);
        $email = session()->get('admin_password_reset_user_email');
        $userResetToken = AdminPasswordReset::where('email', $email)->where('token', $request->token)->first();
        if(!$userResetToken){
            return redirect(route('admin.password.request'))->with('error',translate('Invalid token'));
        }
        $userResetToken->delete();
        $admin           = Admin::where('email', $email)->first();
        $admin->password = Hash::make($request->password);
        $admin->save();

        if(session()->get('admin_password_reset_user_email')){
            session()->forget('admin_password_reset_user_email');
        }
        $mailCode = [
            'time' => Carbon::now(),
            'code' => $request->token
        ];
        SendMail::MailNotification($admin,'PASSWORD_RESET_CONFIRM',$mailCode);
        $userResetToken->delete();
        return redirect(route('admin.login'))->with('success',translate("Password changed successfully"));
    }
}
