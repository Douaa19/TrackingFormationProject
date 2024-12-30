

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
                                                {{translate("Forget Password")}} | {{site_settings('site_name')}}
                                            </p>
                                        </div>
                                        <div >
                                            <form action="{{route('admin.password.email')}}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        <a href="{{route('admin.login')}}" class="text-muted">
                                                                {{translate("Login")}} ?
                                                        </a>
                                                    </div>
                                                    <label for="email" class="form-label">
                                                        {{translate("Email")}} <span class="text-danger" >*</span>
                                                    </label>
                                                    <input type="email" name="email" required   class="form-control" id="email" placeholder="{{translate("Enter Your Email")}}">
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

