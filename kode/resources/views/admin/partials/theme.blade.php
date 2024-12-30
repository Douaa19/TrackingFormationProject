@php

$primaryRgba      =  hexa_to_rgba(site_settings('primary_color'));
$secondaryRgba    =  hexa_to_rgba(site_settings('secondary_color'));

$primary_light    = "rgba(".$primaryRgba.",0.055)";
$secondary_light  = "rgba(".$primaryRgba.",0.05)"; 

@endphp

<style>
:root{
    --color-primary: {{ site_settings('primary_color') }} !important;
    --color-primary-light : {{$primary_light}} !important;
    --text-primary: {{ site_settings('text_primary') }} !important ;
    --text-secondary: {{ site_settings('text_secondary') }} !important ;
  
    --color-secondary: {{ site_settings('secondary_color') }} !important;
    --color-secondary-light: {{$secondary_light}} !important;

}
</style>