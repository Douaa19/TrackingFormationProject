
<section class="find mt-100 pb-100">
    <div class="container ">
      <div class="find-container">
          <div class="row">
            <div class="col-xl-6 col-md-8 mx-auto">
                <div class="section-title title-center text-center">
                    <span class="sub-title">{{@frontend_section_data($cta->value,'sub_title')}}</span>
                    <h3 class="sec-title">
                        {{@frontend_section_data($cta->value,'title')}}
                    </h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-7 col-md-8 mx-auto text-center">
                <p class="find-desc"> {{@frontend_section_data($cta->value,'description')}}</p>
                <div class="d-flex align-items-center justify-content-center flex-column flex-sm-row gap-lg-4 gap-3 button-group">
                    <a href="{{route('ticket.create')}}" class="Btn secondary-btn btn--lg btn-icon-hover">
                         <span>{{translate("Create Ticket")}}</span>
                         <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="#contactSection" class="Btn primary-btn btn--lg btn-icon-hover">
                        <span> {{translate('Contact')}}</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
      
      </div>
    </div>
</section>
