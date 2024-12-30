<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminPasswordReset;
use Carbon\Carbon;
use App\Http\Utility\SendMail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
class NewPasswordController extends Controller
{
    public function create() :View
    {
        $title = "forgot password";
        return view('admin.auth.forgot-password', compact('title'));
    }

    public function store(Request $request) :RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ],[
            'email.required' => translate("Email Feild Is Required"),
            'email.email'    => translate("Enter A Valid Email"),
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->with('error',translate("Email not found"));
        }

        AdminPasswordReset::where('email', $request->email)->delete();

        $passwordReset = AdminPasswordReset::create([
            'email'      => $request->email,
            'token'      => generateRandomNumber(),
            'created_at' => Carbon::now(),
        ]);

        $mailCode = [
            'code' => $passwordReset->token,
            'time' => $passwordReset->created_at,
        ];

        SendMail::MailNotification($admin,'ADMIN_PASSWORD_RESET',$mailCode);

        session()->put('admin_password_reset_user_email', $request->email);
        return redirect(route('admin.password.verify.code'))->with("success",translate("Check your email password reset code sent successfully"));

    }


    public function passwordResetCodeVerify() {
        $title = "Admin Password Reset";

        if(!session()->get('admin_password_reset_user_email')) {

            return redirect()->route('admin.password.request')->with('error',translate('Your email session expired please try again'));
        }

        return view('admin.auth.verify',compact('title'));
    }

    public function emailVerificationCode(Request $request) :RedirectResponse
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $code = preg_replace('/[ ,]+/', '', trim($request->code));
        $email = session()->get('admin_password_reset_user_email');
        $adminResetToken = AdminPasswordReset::where('email', $email)->where('token', $code)->first();

        if(!$adminResetToken){

        	if(session()->get('admin_password_reset_user_email')){
	            session()->forget('admin_password_reset_user_email');
	        }
            return redirect(route('admin.password.request'))->with('error',translate('Invalid token'));
        }

        return redirect()->route('admin.password.reset', $code)->with('success',translate('Change your password'));

    }

}
