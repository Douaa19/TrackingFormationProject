<section class="about pt-100">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5 order-lg-1 order-2 pe-lg-5">
                <div class="about-image">
                    <img src="{{getImageUrl(getFilePaths()['frontend']['path']."/". @frontend_section_data($explore->value,'banner_image')) }}" alt="{{@frontend_section_data($explore->value,'banner_image')}}">
                </div>
            </div>

            <div class="col-lg-7 order-lg-2 order-1">
                <div class="section-title title-left">
                    <span class="sub-title">  {{@frontend_section_data($explore->value,'sub_title')}}</span>
                    <h3 class="sec-title">
                        {{@frontend_section_data($explore->value,'title')}}
                    </h3>
                </div>

                <div class="about-content">
                    <p>
                        {{@frontend_section_data($explore->value,'description')}}
                    </p>

                    <a href="{{@frontend_section_data($explore->value,'btn_url')}}" class="Btn secondary-btn btn--lg btn-icon-hover mt-30">
                     <span>{{@frontend_section_data($explore->value,'btn_text')}}</span>
                     <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
