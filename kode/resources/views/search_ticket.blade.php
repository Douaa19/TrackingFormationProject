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
                                {{translate("Search Ticket Here")}}
                            </h3>
                            <form action="{{route('ticket.search')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        {{translate("Email")}} <span class="text-danger" >*</span>
                                    </label>
                                    <input required type="email" name="email" required value="{{old('email')}}"   class="form-control" id="email" placeholder="{{translate("Enter Email")}}">
                                </div>
                                <div class="mb-4">
                                    <label for="ticket_number" class="form-label">
                                        {{translate("Ticket Number")}} <span class="text-danger" >*</span>
                                    </label>
                                    <input required type="text" name="ticket_number" id="ticket_number" required   class="form-control" id="username" placeholder="{{translate("Enter Ticket Number")}}">
                                </div>
                                <button class="Btn btn--lg secondary-btn header-button btn-icon-hover d-sm-flex  w-100" type="submit">
                                    <span>{{translate("Search Ticket")}}</span>
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
