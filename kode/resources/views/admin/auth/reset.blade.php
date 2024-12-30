

@extends('admin.layouts.auth')
@section('main_content')
    <div class="container-fluid px-md-0">
        <div class="vh-100">
            <div class="row g-0 justify-content-center w-100">
                <div class="col-md-8 col-lg-6">
                    <div class="auth-right">
                        <div class="row align-items-center justify-content-center h-100">
                            <div class="col-xl-5 col-lg-10 col- mx-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-header mt-2">                                         
                                          <a href="{{route('admin.dashboard')}}" class="auth-logo">
                                            <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_lg')) }}" alt="{{site_settings('site_logo_lg')}}" class="w-100 h-100">
                                          </a>
                                         
                                            <p class="text-dark mt-3 mb-0">
                                                {{translate("Update Password")}} | {{site_settings('site_name')}}
                                            </p>
                                        </div>
                                        <div>
                                            <form action="{{route('admin.password.reset.update')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="token" value="{{$passwordToken}}">

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">
                                                        {{translate("Password")}} <span class="text-danger" >*</span>
                                                    </label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input required  type="password"  name="password" class="form-control pe-5 password-input" placeholder="{{translate("Enter password")}}" id="password-input">
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i  data-type='forget-password'  id="toggle-password" class="ri-eye-fill align-middle"></i></button>
                                                    </div>

                                                </div>

                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        <a href="{{route('admin.login')}}" class="text-muted">
                                                                {{translate("Login")}} ?
                                                        </a>
                                                    </div>

                                                    <label class="form-label" for="confirm-password-input">
                                                        {{translate("Confrim Password")}} <span class="text-danger" >*</span>
                                                    </label>
                                                   <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input required  type="password"  name="password_confirmation" class="form-control pe-5 password_confirmation-input" id="confirm-password-input" placeholder="{{translate("Enter Confirm password")}}" id="password-confirmation-input">
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i data-type='forget-password' id="toggle-password-confirm" class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">
                                                        {{translate("Submit")}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <p class="mb-0 text-dark">
                                        {{@site_settings('copy_right_text')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 @include('admin.auth.content')
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
                 $(this).removeClass('ri-eye-fill').addClass('ri-eye-off-fill');
            } else {
               passwordInput.attr('type', 'password');
               $(this).removeClass('ri-eye-off-fill').addClass('ri-eye-fill');
            }
        });

        $(document).on('click','#toggle-password-confirm',function(e){
            var passwordInput = $("#password-confirmation-input");
            var passwordFieldType = passwordInput.attr('type');
            if (passwordFieldType == 'password') {
                 passwordInput.attr('type', 'text');
                 $(this).removeClass('ri-eye-fill').addClass('ri-eye-off-fill');
            } else {
               passwordInput.attr('type', 'password');
               $(this).removeClass('ri-eye-off-fill').addClass('ri-eye-fill');
            }
        });

</script>

@endpush