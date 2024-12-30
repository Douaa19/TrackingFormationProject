@extends('admin.layouts.auth')
@section('main_content')
    <div class="container-fluid px-md-0">
        <div class="vh-100">
            <div class="row g-0 justify-content-center w-100">
                <div class="col-md-8 col-lg-6">
                    <div class="auth-right">
                        <div class="row align-items-center justify-content-center h-100">
                            <div class="col-xl-6 col-lg-10 col- mx-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-header mt-2">
                                            
                                          <a href="{{route('admin.dashboard')}}" class="auth-logo">
                                            <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('site_logo_lg')) }}" alt="{{site_settings('site_logo_lg')}}" class="w-100 h-100">
                                          </a>

                                            <h2 class="text-dark mt-3 mb-0">
                                                {{translate("Admin Access Portal")}}
                                            </h2>
                                        </div>

                                        <div>
                                            <form action="{{route('admin.authenticate')}}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">
                                                        {{translate("Username")}} <span class="text-danger" >*</span>
                                                    </label>

                                                    <input type="text" name="username" required value="{{is_demo()? 'admin' :''}}"   class="form-control" id="username" placeholder="{{translate("Enter username")}}">

                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">
                                                        {{translate("Password")}} <span class="text-danger" >*</span>
                                                    </label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input required  type="password" value="{{is_demo()? '123123' :''}}" name="password" class="form-control pe-5 password-input" placeholder="{{translate("Enter password")}}" id="password-input">
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i id="toggle-password" class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember_me" value="1" id="auth-remember-check">
                                                    <label class="form-check-label" for="auth-remember-check">
                                                        {{translate("Remember me")}}
                                                    </label>

                                                    <div class="float-end">
                                                        <a href="{{route('admin.password.request')}}" class="text-muted">
                                                                {{translate("Forgot password")}} ?
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <button class="btn btn-success  w-100" type="submit">
                                                        {{translate("Sign In")}}
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
           $("#toggle-password").removeClass('ri-eye-fill').addClass('ri-eye-off-fill');
        } else {
        passwordInput.attr('type', 'password');
          $("#toggle-password").removeClass('ri-eye-off-fill').addClass('ri-eye-fill');
        }
   });


</script>

@endpush
