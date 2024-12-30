
@extends('frontend.layouts.master')
@section('content')

@php
    $flag = App\Enums\StatusEnum::false->status();
    $socail_login_credential = json_decode(site_settings('social_login'),true);
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
            <div class=" d-flex align-items-center justify-content-center flex-column">
                <div class="row g-0 justify-content-center w-100">
                    <div class="col-xl-6 col-lg-8 col-md-10 mx-auto">
                        <div class="card form-wrapper card-effect">
                            <div class="card-body p-0">
                                <div class="form-header text-center">
                                    <h4>{{translate("Create Your New Account")}}</h4>
                                    <p>{{translate("Unlock Exclusive Access: Begin Your Journey Here!")}}</p>
                                </div>

                                <div class="mt-4">
                                    <form id="login-form" action="{{route('registration.verify')}}" method="post">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="name" class="form-label">
                                                {{translate('Name')}} <span class="text-danger" >*</span>
                                            </label>
                                            <div class="position-relative">

                                                <input required type="text" value="{{old("name")}}" name="name" class="form-control pe-5" id="name" placeholder="{{translate('Enter Your Name')}}" >
                                                 <span class="input-icon" >
                                                    <i class="bi bi-person"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="email" class="form-label">
                                                {{translate('Email')}} <span class="text-danger" >*</span>
                                            </label>
                                            <div class="position-relative">
                                                <input required type="email" value="{{old("email")}}" name="email" class="form-control pe-5" id="email" placeholder="{{translate('Enter Your Email')}}">

                                                <span class="input-icon" >
                                                   <i class="bi bi-envelope"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label" for="password-input">
                                                {{translate("Password")}} <span class="text-danger" >*</span>
                                            </label>
                                            <div class="position-relative auth-pass-inputgroup mb-4">
                                                <input required  type="password"  name="password" class="form-control pe-5 password-input" placeholder="{{translate("Enter password")}}" id="password-input">
                                               <span class="input-icon password-addon" id="password-addon">
                                                    <i class="bi bi-eye" id="toggle-password"></i>
                                                </span>
                                            </div>

                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label" for="password-input-confirm">
                                                {{translate("Confrim Password")}} <span class="text-danger" >*</span>
                                            </label>

                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input required  type="password"  name="password_confirmation" class="form-control pe-5 password_confirmation-input" placeholder="{{translate("Enter Confirm password")}}" id="password-confirmation-input">
                                                <span class="input-icon password-addon" id="password-addon">
                                                    <i class="bi bi-eye" id="toggle-password-confirm"></i>
                                                </span>
                                            </div>
                                        </div>

                                        @php
                                            $termsCondition = $pages->where('slug','terms-condition')->first();
                                        @endphp

                                        <div class="form-check form-check-inline i-checkbox">
                                            <input  class="form-check-input" name="agree" type="checkbox" id="t&c"
                                                value="1" {{site_settings('terms_accepted_flag') == App\Enums\StatusEnum::true->status() ? "required" :""}}>
                                            <label class="form-check-label mt-1" for="t&c">
                                                 {{translate("By completing the registration process, you agree and accept our ")}} @if($termsCondition)<a class="text-decoration" href="{{route('pages',$termsCondition->slug)}}">{{$termsCondition->title}}</a>
                                                @endif
                                             </label>
                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" class="Btn secondary-btn btn--lg btn-icon-hover w-100 d-flex align-items-center justify-content-center" type="submit">
                                                <span>{{translate("Register")}}</span>
                                                <i class="bi bi-arrow-right"></i>
                                            </button>
                                        </div>

                                        @if($flag == App\Enums\StatusEnum::true->status() )
                                            <div class="text-center">
                                                <div class="signin-other-title">
                                                    <h5 class="title">
                                                        {{translate('Or')}}
                                                    </h5>
                                                </div>
                                               <div class="d-flex align-items-center justify-content-center flex-wrap gap-3">
                                                    @foreach($mediums as $medium)

                                                    <a href="{{route('social.login', $medium)}}" class="auth-btn"><div class="auth-img"><img src="{{asset("assets/images/".$medium.".png")}}"/></div> {{ucfirst($medium)}}
                                                    </a>

                                                    @endforeach

                                                </div>
                                            </div>
                                       @endif
                                    </form>
                                </div>

                                <div class="mt-4 text-center footer-text">
                                    <p> {{translate("Already Have An Account")}} ?
                                        <a href="{{route("login")}}" class="fw-semibold text-decoration-underline">
                                            {{translate('Login')}}
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

        $(document).on('click','#toggle-password',function(e){
            var passwordInput = $("#password-input");
            var passwordFieldType = passwordInput.attr('type');
            if (passwordFieldType == 'password') {
                 passwordInput.attr('type', 'text');
                 $(this).removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
               passwordInput.attr('type', 'password');
               $(this).removeClass('bi-eye-slash').addClass('bi-eye')
            }
        });

        $(document).on('click','#toggle-password-confirm',function(e){
            var passwordInput = $("#password-confirmation-input");
            var passwordFieldType = passwordInput.attr('type');
            if (passwordFieldType == 'password') {
                 passwordInput.attr('type', 'text');
                 $(this).removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
               passwordInput.attr('type', 'password');
               $(this).removeClass('bi-eye-slash').addClass('bi-eye')
            }
        });


    </script>
@endpush
