<section class="pt-100 pb-100 contact-section" id="contactSection">
    <div class="container">
        <div class="row align-items-start gy-5">
            <div class="col-lg-6 pe-lg-5 mx-auto order-lg-1 order-2">
                    <div class="contact-right">
                        <h4 class="small-title">{{translate('Write Us')}}</h4>
                        <form action="{{route('contact.store')}}" method="post" class="contact-form form">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="name" class="form-label">
                                            {{translate('Name')}} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" required  value="{{old('name')}}" name="name" id="name" placeholder="{{translate('Enter Your Name')}}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="email" class="form-label">
                                            {{translate("Email")}} <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" name="email" required value="{{old('email')}}" id="email" placeholder="{{translate('Enter Your Email')}}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="subject" class="form-label">
                                            {{translate("Subject")}} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="subject" required value="{{old('subject')}}" id="subject" placeholder="{{translate('Enter Your Subject')}}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="message" class="form-label">
                                            {{translate("Message")}} <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="message" required id="message" rows="4" placeholder="{{translate('Type Your Message Here.......... ')}}"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <button type="submit"
                                        class="Btn primary-btn-outline btn--lg  btn-icon-hover btnwithicon mt-3 submit-btn text-center">
                                        <span> {{translate('Submit')}}</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class=" contact-left">
                    </div>
            </div>

            <div class="col-lg-6 ps-lg-5 order-lg-2 order-1">
               <div class="row">
                   <div class="col-12">
                       <div class="section-title title-left w-100">
                           <span class="sub-title">
                            {{@frontend_section_data($contact->value,'title')}}
                           </span>
                           <h3 class="sec-title">
                               {{@frontend_section_data($contact->value,'sub_title')}}
                           </h3>
                       </div>
                   </div>
               </div>

                <div class="row justify-content-start">
                    <div class="col-lg-12 col-md-6 col-11">
                        <div class="contact-item mb-45">
                            <div class="contact-icon">
                                <i class="bi bi-chat-left-text"></i>
                            </div>

                            <div class="contact-option">
                                <h4>
                                  {{translate('Email us')}}
                                </h4>
                                <p>
                                     {{translate("Our friendly team is here to help.")}}
                                </p>
                                <a href="mailto:{{site_settings('email')}}">
                                    {{site_settings('email')}}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-6 col-11">
                        <div class="contact-item mb-45">
                            <div class="contact-icon">
                             <i class="bi bi-telephone"></i>
                            </div>

                            <div class="contact-option">
                                <h4>
                                  {{translate("Call to us")}}
                                </h4>
                                <p>
                                    {{translate("Mon-Fri From 10am to 6pm")}}
                                </p>
                                <a href="call:{{site_settings('phone')}}">{{site_settings('phone')}}</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-6 col-11">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div class="contact-option">
                                <h4>
                                        {{translate("Visit us")}}
                                </h4>
                                <p> {{translate("Come say hello at our office HQ")}}</p>
                                {{site_settings('address')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
