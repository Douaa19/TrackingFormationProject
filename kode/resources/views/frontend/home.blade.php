
@extends('frontend.layouts.master')
@section('content')

   @php
      $newsLatter = frontend_section('newsletter_section');
      $banner_section = frontend_section('banner_section');
      $support_section = frontend_section('support_section');
      $faq_section = frontend_section('faq_section');
      $cta_section = frontend_section('cta_section');
      $explore_section = frontend_section('explore_section');
      $contact_section = frontend_section('contact_section');
      
   @endphp

   @includeWhen($banner_section->status == App\Enums\StatusEnum::true->status(), 'frontend.section.banner', ['banner' => $banner_section])
   @includeWhen($explore_section->status == App\Enums\StatusEnum::true->status(), 'frontend.section.explore', ['explore' => $explore_section])
   @includeWhen($support_section->status == App\Enums\StatusEnum::true->status(), 'frontend.section.support', ['support' => $support_section ,'categories'=>$categories])
   @includeWhen($faq_section->status == App\Enums\StatusEnum::true->status(), 'frontend.section.faq', ['faq' => $faq_section])

   @includeWhen($cta_section->status == App\Enums\StatusEnum::true->status(), 'frontend.section.cta', ['cta' => $cta_section])
   @includeWhen($contact_section->status == App\Enums\StatusEnum::true->status(), 'frontend.section.contact', ['contact' => $contact_section])

@endsection
