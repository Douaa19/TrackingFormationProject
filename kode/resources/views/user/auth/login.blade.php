
@extends('frontend.layouts.master')
@section('content')

@php
    $flag =  App\Enums\StatusEnum::false->status();
    $gcaptcha = App\Enums\StatusEnum::false->status();
    $socail_login_credential = json_decode(site_settings('social_login'),true);
    $google_recaptcha = json_decode(site_settings('google_recaptcha'),true);
    $mediums = [];
    foreach($socail_login_credential as $key=>$login_medium){
        if($login_medium['status'] == App\Enums\StatusEnum::true->status()){
            array_push($mediums, str_replace('_oauth',"",$key));
            $flag =  App\Enums\StatusEnum::true->status();
        }
    }
@endphp

    <div class="form-section pt-100">
        <div class="container pt-100 pb-100">
            <div class="d-flex align-items-center justify-content-center flex-column">
                <div class="row g-0 justify-content-center w-100">
                    <div class="col-xl-6 col-lg-8 col-md-10 mx-auto">
                        <div class="card form-wrapper card-effect">
                            <div class="card-body p-0">
                                <div class="form-header text-center">
                                    <h4 class="mb-2">{{translate("Log Into Your Account")}}</h4>
                                    <p>{{translate("We're glad to see you again!")}}</p>
                                </div>

                                <div class="mt-4">
                                    <form id="login-form" action="{{route('login.store')}}" method="post">
                                        @csrf

                                        <div class="mb-4">
                                            <label for="email" class="form-label">
                                                {{translate('Email')}} <span class="text-danger" >*</span>
                                            </label>

                                            <div class="position-relative">
                                                <input required type="email"  value="{{is_demo()? 'demo@demo.com' :''}}" name="email" class="form-control pe-5" id="email" placeholder="{{translate('Enter Your Email')}}">
                                                 <span class="input-icon" >
                                                    <i class="bi bi-person"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label" for="password-input">
                                                {{translate("Password")}} <span class="text-danger" >*</span>
                                            </label>

                                            <div class="position-relative auth-pass-inputgroup mb-4">
                                                <input required  type="password"  name="password" value="{{is_demo()? '123123' :''}}" class="form-control pe-5 password-input" placeholder="{{translate("Enter password")}}" id="password-input">
                                                <span class="input-icon password-addon" id="password-addon">
                                                    <i class="bi bi-eye" id="toggle-password"></i>
                                                </span>
                                            </div>

                                        </div>

                                        @if(site_settings('captcha') == App\Enums\StatusEnum::true->status())
                                            <div class="mb-4">
                                                @if($google_recaptcha ['status'] ==  App\Enums\StatusEnum::true->status())
                                                @php
                                                    $gcaptcha =  App\Enums\StatusEnum::true->status();
                                                @endphp
                                                    <div id="recaptcha" class="w-100" data-type="image"></div>
                                                @elseif(site_settings('default_recaptcha') ==  App\Enums\StatusEnum::true->status())
                                                    <div class="row align-items-center">
                                                        <div class="col-5">
                                                            <div>
                                                                <a id='genarate-captcha' class="d-flex align-items-center">
                                                                    <img class="captcha-default pe-2 pointer" src="{{ route('captcha.genarate',1) }}" id="default-captcha">
                                                                    <i class="bi bi-arrow-clockwise fs-3 pointer lh-1"></i>

                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <input type="text" class="form-control  p-2" required name="default_captcha_code" value="" placeholder="{{translate('Enter captcha value')}}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="d-flex align-items-center justify-content-between gap-3">
                                            <div class="form-check i-checkbox">
                                                <input class="form-check-input" type="checkbox" value="1" name="remember" id="auth-remember-check">
                                                <label class="form-check-label" for="auth-remember-check">
                                                    {{translate("Remember me")}}
                                                </label>
                                            </div>

                                            <a href="{{route('password.request')}}">
                                            {{translate("Forgot password")}}?</a>
                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" class="Btn secondary-btn btn--lg btn-icon-hover w-100 d-flex align-items-center justify-content-center" type="submit">
                                                <span> {{translate("Login")}}</span>
                                                <i class="bi bi-arrow-right"></i>
                                            </button>
                                        </div>

                                        @if($flag == App\Enums\StatusEnum::true->status() )
                                            <div class="mt-4 text-center">
                                                <div class="signin-other-title">
                                                    <h5 class="title">
                                                        {{translate('OR')}}
                                                    </h5>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
                                                    @foreach($mediums as $medium)

                                                    <a href="{{route('social.login', $medium)}}" class="auth-btn"><div class="auth-img"><img src="{{asset("assets/images/".$medium.".png")}}"/></div> {{ucfirst($medium)}}
                                                    </a>

                                                    @endforeach
                                                    @if(site_settings('authenticate_with_envato'))
                                                        <a href="{{route('social.login', 'envato')}}" class="auth-btn"><div class="auth-img"><img src="{{asset("assets/images/".$medium.".png")}}"/></div> {{ucfirst($medium)}}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </form>
                                </div>

                                <div class="mt-4 text-center footer-text">
                                    <p> {{translate("Don't have an account")}} ? <a href="{{route("register")}}" class="fw-semibold text-decoration-underline">
                                            {{translate("Create New")}}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>

@endsection
@push('script-push')
    <script>
        'use strict'

        $(document).on('click','#genarate-captcha',function(e){
            var url = "{{ route('captcha.genarate',[":randId"]) }}"
            url = (url.replace(':randId',Math.random()))
            document.getElementById('default-captcha').src = url;
            e.preventDefault()
        })

        $(document).on('click','#toggle-password',function(e){
            var passwordInput = $("#password-input");
            var passwordFieldType = passwordInput.attr('type');
            if (passwordFieldType == 'password') {
            passwordInput.attr('type', 'text');
            $("#toggle-password").removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
            passwordInput.attr('type', 'password');
            $("#toggle-password").removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });


    </script>

    @if($gcaptcha == App\Enums\StatusEnum::true->status() )
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
        <script type="text/javascript">
        "use strict";
            var onloadCallback = function () {
                grecaptcha.render('recaptcha', {
                    'sitekey':"{{   $google_recaptcha['key']  }}"
                });
            };

            //CAPTCHA CHECK VALIDATIONEV EVENT
            $("#login-form").on('submit',function(e) {
                let  responseData = grecaptcha.getResponse();
                if (responseData.length === 0) {
                    toastr("{{translate('Please Check Recaptcha!! Then Try Again')}}",'danger')
                    e.preventDefault()
                }
            });
        </script>
    @endif
@endpush

