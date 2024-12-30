<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use App\Http\Utility\SendMail;
use Illuminate\Http\RedirectResponse;
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     */
    public function create() :\Illuminate\Contracts\View\View
    {
        $title = "forgot password";
        return view('user.auth.forgot-password', compact('title'));
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) :RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ],
        [
            'email.required' => translate("Email Feild Is Required"),
            'email.email' => translate("Enter A Valid Email"),
        ]
        );
   
        $user = User::where('email',$request->email)->first();
        
        if (!$user) {
            return back()->with('error',translate("Email not found"));
        }
        PasswordReset::where('email', $request->email)->delete();
        $passwordReset = PasswordReset::create([
            'email' => $request->email,
            'token' => generateRandomNumber(),
            'created_at' => Carbon::now(),
        ]);
        $mailCode = [
            'code' => $passwordReset->token, 
            'time' => $passwordReset->created_at,
        ];
        SendMail::MailNotification($user,'PASSWORD_RESET',$mailCode);
        session()->put('password_reset_user_email', $request->email);
        return redirect(route('password.verify.code'))->with("success",translate("Check your email password reset code sent successfully"));
    }


    public function passwordResetCodeVerify(){
        $title = 'Password Reset';
        $route = "email.password.verify.code";
        if(!session()->get('password_reset_user_email')) {
            return redirect()->route('password.request')->with('error',translate('Your email session expired please try again'));
        }
        return view('user.auth.verify_code',compact('title','route'));
    }


    public function emailVerificationCode(Request $request) :RedirectResponse
    {
        $this->validate($request, [
            'code' => 'required'
        ]);
        $code = preg_replace('/[ ,]+/', '', trim($request->code));
        $email = session()->get('password_reset_user_email');
        $userResetToken = PasswordReset::where('email', $email)->where('token', $code)->first();
        if(!$userResetToken){
            return redirect(route('password.request'))->with('error',translate('Invalid token'));
        }
        return redirect()->route('password.reset', $code)->with('error',translate('Change your password.'));

    }
}
