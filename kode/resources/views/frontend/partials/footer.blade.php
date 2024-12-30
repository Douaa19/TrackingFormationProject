@php
    $footer_section = frontend_section('footer_section');
    $social_section = frontend_section('social_section');
    $icons = json_decode($social_section->value,true)['static_element'];
    $newsLatter = frontend_section('newsletter_section');
@endphp


@if($footer_section->status ==  App\Enums\StatusEnum::true->status() )
    <footer class="footer">
        <div class="container">
            <div class="row footer-top gy-5">
                <div class="col-xl-4 col-lg-6 col-md-12 pe-lg-4">

                    <div class="footer-info">
                        <a  href="{{route('home')}}"  class="site-logo">
                            <img src="{{ getImageUrl(getFilePaths()['site_logo']['path']."/".site_settings('frontend_logo')) }}" alt="{{site_settings('frontend_logo')}}">
                        </a>

                        <p class="fs-15">
                            {{@frontend_section_data($footer_section->value,'text')}}
                        </p>
                    </div>
                </div>
                <div class="col-xl-2 d-flex justify-content-lg-center justify-content-start col-lg-6 col-md-6 offset-md-0">
                    <div class="footer-item">
                        <h5 class="footer-item-title">
                            {{translate('Important Links')}}
                        </h5>
                        <div class="footer-menu">
                            @foreach($menus as $menu)
                                <a href="{{$menu->url}}">
                                {{$menu->name}}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 d-flex justify-content-lg-center justify-content-start col-lg-6 col-md-6 offset-md-0">
                    <div class="footer-item">
                        <h5 class="footer-item-title">
                            {{translate("Quick Link")}}
                        </h5>
                        <div class="footer-menu">
                            @foreach($pages as $page)
                              <a href="{{route('pages',$page->slug)}}">{{$page->title}}</a>
                            @endforeach

                            @foreach($quick_menus as $quick_menu)
                                <a href="{{$quick_menu->url}}">
                                {{$quick_menu->name}}
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>


                @if($social_section->status ==  App\Enums\StatusEnum::true->status())
                    <div class="col-xl-3 col-lg-6 col-md-12">
                        <div class="footer-item">
                            <h5 class="footer-item-title">
                                {{translate("Social Links")}}
                            </h5>
                            <div class="footer-social">
                                @foreach(  $icons as $icon)
                                    <a target="_blank" href="{{$icon['url']}}" class="contact-icon">
                                        @php echo $icon['icon']@endphp
                                    </a>
                                @endforeach
                        </div>
                        </div>
                    </div>
                @endif

            </div>
            <div class="row footer-bottom">
                <span>
                    {{site_settings("copy_right_text")}}
                </span>
            </div>
        </div>
    </footer>
@endif

@if($newsLatter->status ==  App\Enums\StatusEnum::true->status())
<div class="newsletter-section bg--secondary pt-60 mt-60 pb-60">
    <div class="news-icon">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"   x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" ><g><path d="M337.649 435.055c-6.959 0-13.266-4.088-16.15-10.509l-.001-.003-72.535-161.527-161.527-72.535c-6.552-2.943-10.675-9.448-10.506-16.573.164-6.881 4.391-12.949 10.77-15.458L488.281.896c6.444-2.534 13.815-.955 18.787 4.018 4.971 4.973 6.547 12.346 4.014 18.784L353.529 424.28c-2.51 6.379-8.577 10.606-15.458 10.77-.14.003-.282.005-.422.005zM124.267 175.23l140.448 63.069a17.826 17.826 0 0 1 8.966 8.967l63.068 140.446L474.5 37.479z"  data-original="#000000" ></path><path d="M259.613 266.866a14.455 14.455 0 0 1-10.253-4.247c-5.663-5.663-5.663-14.844 0-20.506l90.092-90.092c5.662-5.663 14.844-5.663 20.506 0 5.663 5.663 5.663 14.843 0 20.506l-90.092 90.092a14.455 14.455 0 0 1-10.253 4.247zM88.921 437.559a14.455 14.455 0 0 1-10.253-4.247c-5.663-5.662-5.663-14.844 0-20.506L182.574 308.9c5.662-5.662 14.844-5.662 20.506 0 5.663 5.662 5.663 14.844 0 20.506L99.174 433.312a14.455 14.455 0 0 1-10.253 4.247zM158.989 511.831a14.455 14.455 0 0 1-10.253-4.247c-5.663-5.662-5.663-14.844 0-20.506l66.937-66.937c5.662-5.662 14.844-5.662 20.506 0 5.663 5.662 5.663 14.844 0 20.506l-66.937 66.937a14.455 14.455 0 0 1-10.253 4.247zM14.543 367.385a14.453 14.453 0 0 1-10.253-4.247c-5.663-5.662-5.663-14.844 0-20.506l66.937-66.937c5.663-5.663 14.843-5.663 20.506 0 5.663 5.662 5.663 14.844 0 20.506l-66.937 66.937a14.457 14.457 0 0 1-10.253 4.247z"  data-original="#000000" ></path></g></svg>
    </div>
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-6">
                <div class="newsletter-title">
                    <h3>    {{@frontend_section_data($newsLatter->value,'title')}}</h3>
                    <p class="fs-15"> {{@frontend_section_data($newsLatter->value,'description')}}</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="footer-item footer-newsletter">

                    <form action="{{route("subscribe")}}" class="newsletter-form" method="post">

                        @csrf
                        <div class="newsletter-form-box">
                            <input type="email" value="{{old("email")}}" name="email" placeholder="{{translate("Enter Your Email")}}">
                            <button type="submit" class="btn--lg btn-icon-hover d-flex align-items-center justify-content-center gap-2">
                                <span>{{translate('Subscribe')}}</span> <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif





