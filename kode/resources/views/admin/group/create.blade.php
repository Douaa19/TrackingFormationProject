@extends('admin.layouts.master')



@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">
                        {{translate('Create  Group')}}
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
                                {{translate('Home')}}
                            </a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.group.index')}}">
                                {{translate('Groups')}}
                            </a></li>
                            <li class="breadcrumb-item active">
                                {{translate('Create')}}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">
                                {{translate('Create Group')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.group.store')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 pb-3">

                        <div class="col-xl-6 col-lg-6">
                            <div >
                                <label for="Name" class="form-label">
                                    {{translate('Name')}} <span  class="text-danger">*</span>
                                </label>
                                <input required type="text" name="name" value="{{old('name')}}"  class="form-control" placeholder="{{translate("Enter your Name")}}" id="Name">
                                <span class="text-danger">{{translate("Must be unique")}}</span>
                            </div>
                        </div>



                        <div class="col-xl-6 col-lg-6">
                            <div>
                                <label for="priority" class="form-label">
                                    {{translate('Priority')}} <span class="text-danger">*</span>
                                </label>
                                <select  required class="form-select select2" name="priority" id="priority">
                                    @foreach($priorities as $priority)
                                    <option {{old("priority") == $priority->id ?"selected" :"" }} value="{{$priority->id}}">
                                        {{
                                            ($priority->name)
                                        }}
                                    </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{translate("Must be unique")}}</span>
                            </div>
                        </div>



                        <div class="col-xl-6 col-lg-6">
                            <div>
                                <label for="agent" class="form-label">
                                    {{ucfirst(translate('Agents'))}} <span class="text-danger">*</span>
                                </label>
                                <select multiple  required class="form-select select-agent" name="agents[]" id="agent">
                                    @foreach($agents as $agent)

                                        <option @if(old("agents") && in_array($agent->id,old("agents")) ) selected @endif value="{{$agent->id}}">
                                            {{
                                                ($agent->name)
                                            }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="text-start">
                                <button type="submit" class="btn btn-success">
                                    {{translate('Add')}}
                                </button>


                            </div>
                        </div>

                    </div>


                </form>
            </div>
        </div>
    </div>




@endsection



@push('script-push')
<script>
  "use strict";

   $(".select2").select2({
        placeholder:"{{translate('Choose Categoires')}}",

	})
   $(".select-agent").select2({
        tokenSeparators: [',',' ']
	})


</script>


@endpush









