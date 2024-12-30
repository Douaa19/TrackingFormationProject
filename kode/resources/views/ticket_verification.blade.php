@extends('frontend.layouts.master')
@section('content')
@include('frontend.section.breadcrumb')
    <section class="search-ticket pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card search-ticket-card card-effect">
                        <div class="card-body py-lg-5 p-4">
                            <div class="p-2 ">
                                <h3 class="mb-4 text-center">
                                    {{$title}}
                                </h3>
                                <form action="{{route('ticket.otp.verification')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="otp" class="form-label">
                                            {{translate("OTP")}} <span class="text-danger" >*</span>
                                        </label>
                                        <input required type="text" name="otp" required value="{{old('otp')}}"   class="form-control" id="otp" placeholder="{{translate("Enter OTP")}}">
                                    </div>
                                    
                                    <button class="Btn btn--lg secondary-btn header-button btn-icon-hover d-sm-flex  w-100" type="submit">
                                        <span>{{translate("Verify")}}</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
