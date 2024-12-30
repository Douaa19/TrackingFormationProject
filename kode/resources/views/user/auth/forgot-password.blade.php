@extends('frontend.layouts.master')
@section('content')
    <div class="form-section pt-100" >
        <div class="container pt-100 pb-100">
            <div class="d-flex align-items-center justify-content-center flex-column">
                <div class="row justify-content-center g-0 w-100">
                    <div class="col-xl-6 col-lg-8 col-md-10 mx-auto">
                        <div class="card form-wrapper card-effect">
                            <div class="card-body p-0">
                                <div class="form-header text-center">
                                    <h4>{{translate("Reset Password")}}</h4>
                                    <p>{{translate("Please reset your password Here.")}}</p>
                                </div>
                                <div class="mt-4">
                                    <form id="login-form" action="{{route('password.email')}}" method="post">
                                        @csrf

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

                                        <div class="mt-4">
                                            <button type="submit" class="Btn secondary-btn btn--lg btn-icon-hover w-100 d-flex align-items-center justify-content-center" type="submit">
                                                <span>{{translate("Submit")}}</span>
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


