
@extends('frontend.layouts.master')
@section('content')
@include('frontend.section.breadcrumb')
<section class="pt-100 pb-100">
    <div class="container">
        <h2 class="mb-30">{{$page->title}}</h2>
        @php echo $page->description @endphp
    </div>
</section>
@endsection

