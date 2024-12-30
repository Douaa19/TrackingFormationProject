
@extends('frontend.layouts.master')
@section('content')
    <div class="d-flex justify-content-center align-items-center error-section">
            <div class="error-wrap">
                <div class="error-image mb-5">
                    <img src="{{asset('assets/images/global/error-img.png')}}" alt="error-img.png">
                </div>
                <a class="Btn secondary-btn btn-icon-hover btn--lg text-center" href="{{route('home')}}">
                    <span>
                        {{translate("Back to Home")}}
                    </span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
    </div>
@endsection
























