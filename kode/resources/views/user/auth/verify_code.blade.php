@extends('frontend.layouts.master')
@section('content')
<div class="form-section pt-100">
    <div class="container pt-100 pb-100">
        <div class="d-flex align-items-center justify-content-center flex-column">
            <div class="row g-0 justify-content-center w-100">
                <div class="col-xl-6 col-lg-8 col-md-10 mx-auto">
                    <div class="card form-wrapper card-effect">
                        <div class="card-body p-0">
                            <div class="form-header text-center">
                                <h4>{{translate("Verify Code")}}</h4>
                            </div>
                            <div class="mt-4">
                                <form id="login-form" action="{{route($route)}}" method="post">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="code" class="form-label">
                                            {{translate('Verification')}} <span class="text-danger" >*</span>
                                        </label>
                                        <div class="position-relative">
                                            <input required type="text" value="{{old("code")}}" name="code" class="form-control pe-5" id="code" placeholder="{{ translate('Enter Verify Code')}}">

                                               <span class="input-icon" >
                                                    <i class="bi bi-upc-scan"></i>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="Btn secondary-btn btn--lg btn-icon-hover w-100 d-flex align-items-center justify-content-center" type="submit">
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
