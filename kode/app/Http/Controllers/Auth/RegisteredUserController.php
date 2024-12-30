<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Utility\SendMail;
use App\Models\PasswordReset;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     */



    public function create()  :\Illuminate\Contracts\View\View
    {
        $title = "Registration";
        return view('user.auth.register', compact('title'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) :\Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'code' => 'required'
        ]);
        $code = preg_replace('/[ ,]+/', '', trim($request->code));
        $email = session()->get('registration_verify_email');
        $verify_otp = PasswordReset::where('email', $email)->where('token', $code)->first();
        if(!$verify_otp){
            return back()->with('error',translate("Invalid verification code"));
        }
        session()->forget('registration_verify_email');
        $user = User::where('email',$email)->first();
        $user->verified  = (StatusEnum::true)->status();
        $user->save();
        $verify_otp->delete();
        Auth::guard('web')->login($user);
        return redirect(RouteServiceProvider::HOME);
    }

    public function verify(Request $request) :\Illuminate\Http\RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)
                                        ->mixedCase()
                                        ->letters()
                                        ->numbers()
                                        ->symbols()],
        ];
     
        $messages = [
            "name.required" => translate('Name Feild Must Be Required'),
            "email.required" => translate('Email Feild Must Be Required'),
            "email.email" => translate('Enter A Valid Email'),
            "email.unique" => translate('This Email Is Already Taken!! Try Another'),
            "password.required" => translate('Password Feild Must Be Required'),
            "password.confirmed" => translate('Password Doesn\'t Match With Confirm Password')
        ];

        if(site_settings('terms_accepted_flag') == (StatusEnum::true)->status() ){
            $rules['agree'] = ["required"];
            $messages['agree.required'] = translate('You Need To Agree Our Terms & Conditon');
        }
        $request->validate($rules,$messages);
        $verified  = (StatusEnum::true)->status();
        if(site_settings('email_verification') ==  (StatusEnum::true)->status()){
            $verified  = (StatusEnum::false)->status();
        }
        $address_data = get_ip_info();
        $userAgent = request()->header('User-Agent');
        $address_data ['browser_name'] = browser_name($userAgent);
        $address_data ['device_name']  = get_divice_type($userAgent);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => (StatusEnum::true)->status(),
            'verified' =>  $verified ,
            'password' => Hash::make($request->password),
            'address' => json_encode($address_data),
            'longitude' => isset($address_data['lon']) ?  $address_data['lon'] : null,
             "latitude"	 => isset($address_data['lat']) ?  $address_data['lat'] : null
        ]);




        if(site_settings('default_notification') == (StatusEnum::true)->status()){

            set_default_notifications($user);
          
        }

    



        if(site_settings('email_verification') ==  (StatusEnum::true)->status()){
            PasswordReset::where('email', $request->email)->delete();

            $passwordReset = PasswordReset::create([
                'email' => $request->email,
                'token' => generateRandomNumber(),
                'created_at' => Carbon::now(),
            ]);
    
            $mailCode = [
                'name' => $request->name,
                'code' => $passwordReset->token,
                'time' => $passwordReset->created_at,
            ];

            try {
                SendMail::MailNotification($request,'REGISTRATION_VERIFY',$mailCode);
            } catch (\Exception $e) {
                $user->delete();
                PasswordReset::where('email', $request->email)->delete();
                return back()->with('error' ,translate("'Something went wrong!  Please try with valid email'"));
            }
            session()->put('registration_verify_email', $request->email);
            return redirect(route('registration.verify.code'))->with('success',translate("Check your email a code sent successfully for verify registration process"));
        }

        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);

     
      
    }

    public function verifyCode()
    {
        $title = "User Registration Verification";
        $route = "register";
        if(!session()->get('registration_verify_email')) {
            return redirect()->route('registration.verify')->with('error',translate('Your verification session expired please try again'));
        }
        return view('user.auth.verify_code',compact('title','route'));
    }
}