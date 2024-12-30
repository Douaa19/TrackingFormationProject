
@php       
  $authSection = frontend_section('authentication_section');
@endphp

<div class="col-lg-6">
  <div class="auth-left d-lg-flex d-none">
    <div class="w-75 mx-auto">
      <img src="{{ getImageUrl(getFilePaths()['frontend']['path'] . '/' . frontend_section_data($authSection->value, 'banner_image')) }}" alt="{{ frontend_section_data($authSection->value, 'banner_image') }}" class="w-100">
    </div>
    
     <div class="auth-left-content">
        <h3 class="text-white">
          {{translate("Welcome Back ")}} <a href="{{route('home')}}" class="text-muted">{{site_settings('site_name')}}</a>
        </h3>
        <p>{{@frontend_section_data($authSection->value,'description')}}</p>
    </div>
  </div>
</div>

