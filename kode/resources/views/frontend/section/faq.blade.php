
<section class="pt-100">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="section-title title-center text-center">
                    <span class="sub-title"> {{@frontend_section_data($faq->value,'sub_title')}}</span>
                    <h3 class="sec-title">
                        {{@frontend_section_data($faq->value,'title')}}
                    </h3>
                </div>
            </div>
        </div>
        <div class="row gy-5 justify-content-center">
            <div class="col-lg-10">
                <div class="questions-left">
                    <div class="nav flex-row justify-content-center gap-3" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">

                         @php
                           $i = 0;
                           $j = 0;
                         @endphp

                        @foreach ($categories as  $category)
                           @if(count($category->faq) >0)

                                <button class="nav-link {{$i == 0? "active" :""}}" id="v-pills-{{$category->id}}-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-{{$category->id}}" type="button" role="tab"
                                aria-controls="v-pills-{{$category->id}}" aria-selected="true">
                                 {{get_translation($category->name)}}
                                <i class="bi bi-chevron-right"></i>
                                </button>

                                @php
                                    $i++;
                                @endphp
                             @endif
                        @endforeach


                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">

                    @forelse ($categories as $category)
                       @if(count($category->faq) > 0)
                            <div class="tab-pane fade {{$j == 0? "show active" :""}}" id="v-pills-{{$category->id}}" role="tabpanel"
                                aria-labelledby="v-pills-{{$category->id}}-tab" tabindex="0">
                                <div class="custiom-accordion">
                                    <div class="accordion accordion-flush" id="acc{{$category->id}}">

                                        @foreach( $category->faq as $faq)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-heading-{{$faq->id}}">
                                                    <button class="accordion-button
                                                    {{$loop->index != 0 ? "collapsed" :"" }} " type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$faq->id}}"
                                                        aria-expanded="false" aria-controls="flush-collapse-{{$faq->id}}">
                                                        {{$faq->question}}
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse-{{$faq->id}}" class="accordion-collapse collapse {{$loop->index == 0 ? 'show' :"" }} "
                                                    aria-labelledby="flush-heading-{{$faq->id}}"
                                                    data-bs-parent="#acc{{$category->id}}">
                                                    <div class="accordion-body">
                                                        @php echo $faq->answer @endphp
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    </div>

                                </div>
                            </div>
                            @php
                               $j++;
                            @endphp
                       @endif
                    @empty

                    @endforelse



                </div>
            </div>
        </div>
    </div>
</section>
