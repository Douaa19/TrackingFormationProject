

@extends('frontend.layouts.master')
@section('content')

<section class="search-ticket pt-100 pb-100 d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card search-ticket-card card-effect">
                    <div class="card-body py-lg-5 p-4">
                        <div class="p-2 ">
                            <h3 class="mb-4 text-center">
                                {{translate("Verify Yourself")}}
                            </h3>
                            <form action="{{route('dos.security.verify')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                   
                                    <a id='genarate-captcha' class="d-flex align-items-center">
                                      <img class="captcha-default pe-2 pointer" src="{{ route('captcha.genarate',1) }}" id="default-captcha">
                                      <i class="bi bi-arrow-clockwise fs-3 pointer lh-1"></i>

                                  </a>
                                </div>
                                <div class="mb-4">
                                    <label for="captcha" class="form-label">
                                        {{translate("Captcha code")}} <span class="text-danger" >*</span>
                                    </label>
                                    <input required type="text" name="captcha" id="captcha" required   class="form-control" id="captcha" placeholder="{{translate("Enter captcha code")}}">
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
@push('script-push')
    <script>
        'use strict'

        $(document).on('click','#genarate-captcha',function(e){
            var url = "{{ route('captcha.genarate',[":randId"]) }}"
            url = (url.replace(':randId',Math.random()))
            document.getElementById('default-captcha').src = url;
            e.preventDefault()
        })
  </script>
@endpush