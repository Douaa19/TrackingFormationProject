@php
    $auth_section     = frontend_section('authentication_section');

    $primaryRgba      =  hexa_to_rgba(site_settings('primary_color'));
    $secondaryRgba    =  hexa_to_rgba(site_settings('secondary_color'));

    $primary_light    = "rgba(".$primaryRgba.",0.055)";
    $secondary_light  = "rgba(".$secondaryRgba.",0.05)";

@endphp

<style>
    :root{
        --primary:  {{ site_settings('primary_color') }} !important;
        --primary-light : {{$primary_light}} !important;
        --secondary-light : {{$secondary_light}} !important;
        --secondary: {{ site_settings('secondary_color') }} !important;
        --text-primary: {{ site_settings('text_primary') }} !important ;
        --text-secondary: {{ site_settings('text_secondary') }} !important ;
    }
</style>
