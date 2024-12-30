@extends('frontend.layouts.master')
@section('content')
    <div class="form-section pt-100" >
        <div class="container pt-100 pb-100">
            <div class="d-flex align-items-center justify-content-center flex-column">
                <div class="row justify-content-center w-100">
                    <div class="col-xl-6 col-lg-8 col-md-10 mx-auto">
                        <div class="card form-wrapper card-effect">
                            <div class="card-body p-0">
                                <div class="form-header text-center">
                                    <h4>{{translate("Reset Password")}}</h4>
                                </div>
                                <div class="mt-4">
                                    <form action="{{route('password.update')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="token" value="{{$passwordToken}}">

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

                                            <label class="form-label" for="password-confirmation-input">
                                                {{translate("Confrim Password")}} <span class="text-danger" >*</span>
                                            </label>
                                           <div class="position-relative auth-pass-inputgroup mb-4">
                                                <input required  type="password"  name="password_confirmation" class="form-control pe-5 password_confirmation-input" placeholder="{{translate("Enter Confirm password")}}" id="password-confirmation-input">
                                               <span class="input-icon password-addon" id="password-addon">
                                                    <i class="bi bi-eye" id="toggle-password-confirm"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button class="Btn secondary-btn btn--lg btn-icon-hover w-100 d-flex align-items-center justify-content-center" type="submit">
                                               <span> {{translate("Submit")}}</span>

                                                 <i class="bi bi-arrow-right"></i>
                                            </button>
                                        </div>
                                    </form>
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
               $(this).removeClass('bi-eye-slash').addClass('bi-eye');
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
               $(this).removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });

</script>

@endpush
