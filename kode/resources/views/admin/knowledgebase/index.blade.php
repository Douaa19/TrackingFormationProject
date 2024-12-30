@extends('admin.layouts.master')
@push('style-include')
    <link rel="stylesheet" href="{{asset('assets/global/css/bootstrapicons-iconpicker.css') }}">
    <link href="{{asset('assets/global/css/summnernote.css')}}" rel="stylesheet" type="text/css" />

@endpush
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">
                        {{translate($title)}}
					</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('knowledgebase')}}
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header border-bottom-dashed">
                <h4 class="card-title">
                      {{translate("Products")}}
                </h4>
            </div>
            <div class="card-body">
                <div class="basic-setting channel-setting">
                    <div class="nav flex-row nav-pills text-center gap-sm-2 gap-1">


                        @php
                           $knowledgeDepartment =  $departments->where('slug',request()->route('slug'))->first();
                        @endphp

                        @forelse ($departments  as  $department)

                                <a href="{{route('admin.knowledgebase.list',$department->slug)}}" class="nav-link {{$department->slug == request()->route('slug') ? 'active' :''}} ">
                                    <span class="channel-logo">
                                        <img src="{{getImageUrl(getFilePaths()['department']['path']."/". $department->image , getFilePaths()['department']['size']) }}" alt="{{$department->image}}">
                                    </span>
                                     {{$department->name}}
                                </a>
                        @empty

                             <div>
                                 {{translate("No department found")}}
                             </div>

                        @endforelse


                    </div>

                    <div class="mt-3">
                        <a class="text-decoration-underline" href="{{route('admin.department.list')}}">
                            {{translate("See all products")}}
                        </a>
                    </div>
                </div>
            </div>

		</div>

        <div class="card">
            @if(!$knowledgeDepartment)
                <div class="card-body text-center ">
                    {{translate("Plese select a product first")}}
                </div>
            @else

                <div class="card-header border-bottom-dashed">
                    <h4 class="card-title">{{$knowledgeDepartment->name}}</h4>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-xl-5 col-lg-5">
                            <div class="sticky-side-div">
                                @if($knowledgeDepartment->parentKnowledgeBases->count() > 0)

                                <div class="knowledge-hierarchy-main position-relative">
                                    <div class="bg-light p-sm-3 p-2 h-100 knowledge-hierarchy">
                                        @include('admin.knowledgebase.hierarchy')
                                    </div>

                                    <div class="d-none hierarchy-loader" id="hierarchy-loader">
                                        <div class="spinner-border text-primary avatar-sm" role="status">
                                            <span class="visually-hidden"></span>
                                        </div>
                                    </div>
                                </div>

                                @else
                                    <div class="text-center bg-light rounded p-5">
                                       <p class="fs-5 mb-0"> {{Translate("No data found")}}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-7 col-lg-7">
                            <div class="border rounded sticky-side-div">
                                <div class="bg-light p-3">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-auto">
                                            <h5 class="card-title mb-0">
                                                {{ $knowledge ? translate('Update') : translate('Create') }}
                                            </h5>
                                        </div>
                                        @if ($knowledge)
                                            <div class="col-auto">
                                                <a href="{{ route('admin.knowledgebase.list', ['slug' => $knowledgeDepartment->slug]) }}"
                                                    class="btn btn-success add-btn waves ripple-light">
                                                    <i class="ri-add-line align-bottom me-1"></i>
                                                    {{ translate('Create New') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @php
                                    $postURL =  $knowledge ? route('admin.knowledgebase.update')
                                                           : route('admin.knowledgebase.store')
                                @endphp

                                <form action="{{$postURL}}" class="p-3 " method="post">

                                    @csrf

                                    @if($knowledge)
                                        <input type="hidden" name="id" value="{{$knowledge->id}}">
                                    @endif

                                    <input type="hidden" id="departmentId" name="department_id" value="{{$knowledgeDepartment->id}}">

                                    <div class="mb-3">
                                        <label for="icon" class="form-label">
                                             {{translate('Icon')}} <span class="text-danger">*</span>
                                        </label>
                                        <input required type="text" value="{{$knowledge ? $knowledge->icon : old("icon")}}" name="icon" class="form-control icon-picker" id="icon" placeholder="{{translate('Search icon')}}">
                                    </div>


                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                             {{translate('Name')}} <span class="text-danger">*</span>
                                        </label>
                                        <input required type="text" value="{{ $knowledge ? $knowledge->name : old("name")}}" name="name" class="form-control" id="name" placeholder="{{translate('Enter name')}}">
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="form-label">
                                             {{translate('Description')}} <span class="text-danger">*</span>
                                        </label>
                                        <textarea placeholder="{{translate('Enter description')}}" required name="description" class="form-control summernote" id="description" rows="8">{{$knowledge ? $knowledge->description :old("description")}}</textarea>
                                    </div>


                                    <div class="mb-4">

                                        <label for="status" class="form-label">
                                             {{translate('Status')}} <span class="text-danger">*</span>
                                        </label>

                                         <select class="form-select" name="status" id="status">
                                              <option {{ (@$knowledge->status == App\Enums\StatusEnum::true->status()  || old("status") == App\Enums\StatusEnum::true->status()) ? 'selected' :""  }} value="{{App\Enums\StatusEnum::true->status()}}">
                                                   {{translate('Active')}}
                                              </option>
                                              <option {{ (@$knowledge->status == App\Enums\StatusEnum::false->status() || old("status") == App\Enums\StatusEnum::false->status()) ? 'selected' :""  }} value="{{App\Enums\StatusEnum::false->status()}}">
                                                   {{translate('Inactive')}}
                                              </option>
                                         </select>

                                    </div>


                                    <button type="submit" class="btn btn-success">
                                         {{translate("Submit")}}
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

	</div>

@include('modal.delete_modal')

@endsection

@push('script-include')
    <script src="{{asset('assets/global/js/bootstrapicon-iconpicker.js') }}"></script>
    <script src="{{asset('assets/global/js/jquery-migrate-3.0.0.min.j') }}"></script>
    <script src="{{asset('assets/global/js/jscharting.js') }}"></script>
    <script src="{{asset('assets/global/js/jquery-ui.min.js') }}"></script>
    <script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>

@endpush

@push('script-push')
<script>
	(function($){
       	"use strict";


// init drag drop
var dragDrop = (function(dragDrop) {

function isDropable(item) {
    $('.node-element').removeClass('unsetOpacity');
    item[0].classList.add('setOpacity');
    var $target = $(this).closest("li");
    var $item = item.closest("li");

    if ($.contains($item[0], $target[0])) {
        return false;
    }

    return true;

}

function listOver(event, ui) {}

function listOut(event, ui) {}

function listDropped(event, ui) {
    var parent_id  = event.target.id;

    if (parent_id == 'newElement') {
        var checkExits = setInterval(() => {
            if ($('#node-ul-newElement').length) {
                var   $newParent ;
                var departmentId = $('#departmentId').val();
                $('#node-ul-newElement').children('li').each(function() {
              
                     $newParent = $(this).val();
                });

                $.ajax({
                    url: "{{route('admin.knowledgebase.change.parent')}}",
                    type: "POST",

                    beforeSend: function() {
                        $('#hierarchy-loader').removeClass('d-none');
                    },
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "new_parent": $newParent,
                        "department_id": departmentId,

                    },
                    success: function(data) {
                        $('#hierarchy-loader').addClass('d-none');
                        if(data.status ){
                            $('.knowledge-hierarchy').html(data.hierarchy_html)
                            $(function() { dragDrop.enable("#dragParent"); });
                        }else{
                            toastr(data.message,'danger')
                        }
                    },
                    error: function (error){
                        if(error && error.responseJSON){
                            if(error.responseJSON.errors){
                                for (let i in error.responseJSON.errors) {
                                    toastr(error.responseJSON.errors[i][0],'danger')
                                }
                            }
                            else{
                                if((error.responseJSON.message)){
                                    toastr(error.responseJSON.message,'danger')
                                }
                                else{
                                    toastr( error.responseJSON.error,'danger')
                                }
                            }
                        }
                        else{
                            toastr(error.message,'danger')
                        }
                }
                });

                clearInterval(checkExits)
            }
        }, 500);

    }


    var $target = $(this).closest("li");
    var $item = ui.draggable.closest("li");

    var $srcUL = $item.parent("ul");
    var $dstUL = $target.children("ul").first();


    if ($dstUL.length == 0) {
        $dstUL = $("<ul class='sub-menu' id='node-ul-"+parent_id+"'></ul>");
        $target.append($dstUL);
    }

    $item.slideUp(50, function() {

        $dstUL.append($item);

        if ($srcUL.children("li").length == 0) {
            $srcUL.remove();
        }
        $item.slideDown(50, function() {
            $item.css('display', '');
        });

    });

    var checkElementExits = setInterval(() => {
        var values = [];

        if(parent_id == 'newElement'){
            clearInterval(checkElementExits);
        }

        if ($('#node-ul-'+parent_id).length && parent_id != 'newElement') {
            $('#node-ul-'+parent_id).children('li').each(function() {
                values.push($(this).val());
            });

            var departmentId = $('#departmentId').val();
            $.ajax({
                url: "{{route('admin.knowledgebase.change.parent')}}",
                type: "POST",

                beforeSend: function() {
                        $('#hierarchy-loader').removeClass('d-none');
                    },
                data: {
                    "_token": "{{ csrf_token() }}",
                    "values": values,
                    "parent_id": parent_id,
                    "department_id": departmentId,
                },
                dataType: 'json',
                success: function(data) {

                    $('#hierarchy-loader').addClass('d-none');
                    if(data.status ){

                        $('.knowledge-hierarchy').html(data.hierarchy_html)
                        $(function() { dragDrop.enable("#dragParent"); });
                    }else{
                        toastr(data.message,'danger')
                    }
                },


                error: function (error){
                        if(error && error.responseJSON){
                            if(error.responseJSON.errors){
                                for (let i in error.responseJSON.errors) {
                                    toastr(error.responseJSON.errors[i][0],'danger')
                                }
                            }
                            else{
                                if((error.responseJSON.message)){
                                    toastr(error.responseJSON.message,'danger')
                                }
                                else{
                                    toastr( error.responseJSON.error,'danger')
                                }
                            }
                        }
                        else{
                            toastr(error.message,'danger')
                        }
                }
            });

            clearInterval(checkElementExits);
        }
    }, 500);

}

dragDrop.enable = function(selector) {


    $(selector).find(".node-element").draggable({
        helper: "clone"
    });

    $(selector).find(".node-element, .node-facility").droppable({
        activeClass: "active",
        hoverClass: "hover",
        accept: isDropable,
        over: listOver,
        out: listOut,
        drop: listDropped,
        greedy: true,
        tolerance: "pointer"
    });

};

return dragDrop;

})(dragDrop || {});


$(function() {
    dragDrop.enable("#dragParent");
    $('.icon-picker').iconpicker({
                title: "{{translate('Search Here !!')}}",
            });
});



	})(jQuery);
</script>
@endpush





