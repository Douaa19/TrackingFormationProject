<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     */
    public function create() :\Illuminate\Contracts\View\View {
        
        return view('user.auth.login',[
            "title" =>  "User Login"
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request) :\Illuminate\Http\RedirectResponse
    {
        if(site_settings('captcha') == (StatusEnum::true)->status()){
            $response = $this->recaptchValidation($request);
            if($response == 'failed'){
                return back()->with('error',translate('Recaptcha Validation Failed !! try again'));
            }
        }
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME);
    }


    public function recaptchValidation($request){

        $recaptcha = json_decode(site_settings('google_recaptcha'),true);
        
        if (($recaptcha) && $recaptcha['status'] ==  (StatusEnum::true)->status()) {
            try {
                $request->validate([
                    'g-recaptcha-response' => [
                        function ($attribute, $value, $failed) use ( $recaptcha) {
                            $secretkey = $recaptcha['secret_key'];
                            $response = $value;
                            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secretkey . '&response=' . $response;
                            $response = \file_get_contents($url);
                            $response = json_decode($response);
                            if (!$response->success) {
                                $failed(translate('recaptcha Validation failed'));
                            }
                        },
                    ],
                ]);
            } catch (\Exception $exception) {
            }
        }
        elseif(site_settings('default_recaptcha') == (StatusEnum::true)->status()) {
            if (strtolower($request->default_captcha_code) != strtolower(session()->get('gcaptcha_code'))) {
                session()->forget('gcaptcha_code');
                return 'failed';
            }

        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy() :\Illuminate\Http\RedirectResponse
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }

    
}
