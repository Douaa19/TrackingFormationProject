<section class="pt-100">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="section-title text-center title-center">
                    <span class="sub-title">   {{@frontend_section_data($support->value,'sub_title')}}</span>
                    <h3 class="sec-title">
                        {{@frontend_section_data($support->value,'title')}}
                    </h3>
                </div>
            </div>
        </div>

        <div class="row justify-content-center g-4">
            @forelse($categories->where("article_display_flag",App\Enums\StatusEnum::true->status()) as $category)
                <div class="col-xl-3 col-lg-4 col-md-6 col-11">
                    <a href="{{route('articles',['slug'=>make_slug(get_translation($category->name)) ,'id'=>$category->id ])}}" class="support-item">
                        <span>
                            <img  src="{{getImageUrl( getFilePaths()['category']['path']."/". $category->image ,getFilePaths()['category']['size']  ) }}" alt="{{$category->image}}" loading="lazy">
                        </span>
                        <h4 class="pt-3 mb-2">
                            {{get_translation($category->name)}}
                        </h4>
                        <p>
                            {{$category->sort_details}}
                        </p>
                    </a>
                </div>
            @empty
             
                @include('frontend.partials.not_found')
            
            @endforelse
        </div>
    </div>
</section>
