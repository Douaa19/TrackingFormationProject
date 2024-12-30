@if ($categories->isNotEmpty())

    @foreach($categories as $category)
        <a href="javascript:void(0)" data-id="{{$category->id}}" class="{{$category_active == $category->id ? 'active' : ''}} ticket-category mail-list-item">
            <i class="ri-arrow-right-down-line me-3 align-middle fw-medium"></i>
            <span class="mail-list-link">
                {{get_translation($category->name)}}
            </span>
            <span  class="badge badge-soft-success ms-auto ">
                {{$category->tickets_count}}
            </span>
        </a>
    @endforeach

@endif









