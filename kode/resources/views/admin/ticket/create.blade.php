@extends('admin.layouts.master')

@push('styles')
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
                            <li class="breadcrumb-item"><a href="{{route('admin.ticket.list')}}">
                                {{translate('Tickets')}}
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
                                {{translate('Create Ticket')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.ticket.store')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4 pb-3">

                            @php
                                $custom_feild_counter = 0;
                                $custom_rules = [];
                                $yes             = App\Enums\StatusEnum::true->status();
                                $no              = App\Enums\StatusEnum::false->status();

                                $audienceTabs = [

                                    'user' => [
                                        'icon'         => '<i class="ri-user-follow-line nav-icon nav-tab-position"></i>',
                                        'display_name' => 'Users',
                                        'note'         => "By selecting this option, you can include all system user emails for streamlined ticket creation, enhancing efficiency and communication within the system. This ensures comprehensive coverage and facilitates seamless workflow management.",
                                        'input'        => [
                                            'label'    => 'Select User',
                                            'type'     => 'select',
                                            'name'     => 'user_id[]',
                                            'values'   =>   $users,
                                        ]
                                    ],

                                    'contacts' => [
                                        'icon'         => '<i class="ri-contacts-line nav-icon nav-tab-position"></i>',
                                        'display_name' => 'Contacts',
                                        'note'         => "By selecting this option, you can include all system contacts emails for streamlined ticket creation, enhancing efficiency and communication within the system. This ensures comprehensive coverage and facilitates seamless workflow management.",

                                        'input'        => [
                                            'label'    => 'Select Contact',
                                            'type'     => 'select',
                                            'name'     => 'contact[]',
                                            'values'   => $contacts ,
                                        ]
                                    ],

                                    'subscribers' => [
                                        'icon'         => '<i class="ri-mail-volume-line nav-icon nav-tab-position"></i>',
                                        'display_name' => 'Subscribers',
                                        'note'         => "By selecting this option, you can include all system Subscribers emails for streamlined ticket creation, enhancing efficiency and communication within the system. This ensures comprehensive coverage and facilitates seamless workflow management.",
                                        'input'        => [
                                            'label'    => 'Select Subscriber',
                                            'type'     => 'select',
                                            'name'     => 'subscriber[]',
                                            'values'   => $subscribers ,
                                        ]
                                    ],


                                    'anonymous' => [
                                        'icon'         => '<i class="ri-folder-unknow-line nav-icon nav-tab-position"></i>',
                                        'display_name' => 'Anonymous',
                                        'note'         => "By selecting this option, you can include all system guest chat emails for streamlined ticket creation, enhancing efficiency and communication within the system. This ensures comprehensive coverage and facilitates seamless workflow management.",
                                        'input'        => [
                                            'label'    => 'Select User',
                                            'type'     => 'select',
                                            'name'     => 'anonymous[]',
                                            'values'   => $guestUsers ,
                                        ]
                                    ],


                                    'custom' => [
                                        'icon'         => '<i class="ri-user-settings-line nav-icon nav-tab-position"></i>',
                                        'display_name' => 'Custom Email',
                                        'note'         => "By selecting this option, you can input custom user emails for ticket creation, allowing personalized communication and tailored responses within the system",
                                        'input'        => [
                                            'label'    => 'Email',
                                            'type'     => 'select',
                                            'name'     => 'custom_email[]',
                                        ]
                                    ],
                                ];

                            @endphp



                           <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="select-audience bg-light p-3">
                                            <h6>
                                               {{translate("Select Audience")}}
                                            </h6>

                                            <div class="auduience-tabs mb-3">
                                                <ul class="nav nav-pills custom-hover-nav-tabs" role="tablist">

                                                    @foreach ( $audienceTabs  as $tabKey  => $tab )


                                                            <li class="nav-item audience-tab" data-note = "{{Arr::get($tab,'note')}}" role="presentation">
                                                                <a href="#custom-{{$tabKey}}" data-bs-toggle="tab" aria-expanded="false" class="nav-link {{$loop->index == 0 ? "active" :''}}" aria-selected="true" role="tab">
                                                                    @php echo Arr::get($tab,'icon') @endphp
                                                                    <h5 class="nav-titl nav-tab-position m-0">
                                                                       {{Arr::get($tab,'display_name')}}
                                                                    </h5>
                                                                </a>
                                                            </li>

                                                    @endforeach


                                                </ul>
                                            </div>

                                            <div class="tab-content rounded">
                                                @foreach ( $audienceTabs  as $tabKey  => $tab )
                                                    <div class="tab-pane fade {{$loop->index == 0 ? " active show" :''}}" id="custom-{{$tabKey}}" role="tabpanel">
                                                        <div>
                                                            <label for="{{$tabKey}}">
                                                               {{Arr::get( $tab['input'] ,'label')}}
                                                            </label>
                                  
                                                            <select multiple class="select-user form-select" name=" {{Arr::get( $tab['input'] ,'name')}}" id="{{$tabKey}}">

                                                                 @if(!Arr::get( $tab['input'] ,'values',null))
                                                                     <option value="">
                                                                         {{translate('Enter Email')}}
                                                                     </option>
                                                                 @else
                                          

                                                                  @foreach (Arr::get( $tab['input'] ,'values',null) as $value )
                                                                        <option value="{{$value->id}}">
                                                                            {{$value->email}}
                                                                        </option>
                                                                  @endforeach


                                                                 @endif

                                                            </select>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">

                                        <div class="instaction-note alert alert-info material-shadow p-3">
                                            <h6>
                                                    {{translate("Instaction Note")}}
                                            </h6>
                                            <p class="instraction-note">
                                                   {{
                                                      Arr::get(  Arr::first($audienceTabs) ,'note')
                                                   }}

                                            </p>
                                        </div>

                                    </div>
                                </div>

                           </div>


                           <div class="col-md-12">

                            <label for="department_id" class="form-label">
                                   {{translate("Select product")}}
                            </label>

                            <select class="form-select" id="department_id"   name="ticket_data[department_id]" >
                                <option value="">
                                  {{translate("Select product")}}
                                </option>

                                @foreach($departments as $department)
                                    <option
                                    {{old('ticket_data.department_id') == $department->id ? 'selected' :"" }}
                                    value="{{$department->id}}">
                                        {{($department->name)}}
                                    </option>
                                @endforeach

                            </select>

                           </div>


                        @foreach($ticket_fields as $ticket_field)
                                @php

                                    $width           = Arr::get(@$ticket_field,'width',App\Enums\FieldWidth::COL_12->value);

                                    $col             = str_replace('COL_','',  $width);

                                    $field_name      =  Arr::get(@$ticket_field,'name','default');

                                    $visibility      = Arr::get($ticket_field , "visibility", $yes);

                                @endphp

                                @if(($visibility ==  $yes || is_null($visibility)) &&  $field_name  != 'email' && $field_name  != 'name')
                                    <div class="col-md-{{$col}}">
                                        <div>
                                            <label for="{{$loop->index}}" class="form-label">
                                                {{$ticket_field['labels']}} @if($ticket_field['required'] ==   $yes || $ticket_field['type'] == 'file')

                                                @endif
                                            </label>
                                            <span class="{{ $ticket_field['required'] ==   $yes ? 'text-danger' : 'text-muted' }} fs-12">
                                                {{ $ticket_field['required'] ==   $yes ? "*" : "" }}

                                                @if($ticket_field['type'] == 'file')
                                                    ({{ $ticket_field['placeholder'] }} {{ site_settings("max_file_upload") }} {{ translate('files') }} )
                                                @endif
                                            </span>

                                            @if($ticket_field['type'] == 'select' && $field_name ==  "category")

                                                <select class="form-select" id="{{$loop->index}}" {{$ticket_field['required'] ==   $yes ? "required" :""}}  name="ticket_data[{{ $field_name }}]" >
                                                    <option value="">{{$ticket_field['placeholder']}}</option>

                                                    @foreach($categories as $category)
                                                        <option
                                                        {{old('ticket_data.'.$field_name) == $category->id ? 'selected' :"" }}
                                                        value="{{$category->id}}">
                                                            {{get_translation($category->name)}}
                                                        </option>
                                                    @endforeach

                                                </select>
                                        @elseif($ticket_field['type'] == 'select' && $field_name ==  "priority")

                                                <select class="form-select" id="{{$loop->index}}" {{$ticket_field['required'] ==   $yes ? "required" :""}}  name="ticket_data[{{ $field_name }}]" >
                                                    <option value="">{{$ticket_field['placeholder']}}</option>

                                                    @foreach($priorites as $priority)
                                                        <option
                                                        {{old('ticket_data.'.$field_name) == $priority->id ? 'selected' :"" }}
                                                        value="{{$priority->id}}">
                                                            {{($priority->name)}}
                                                        </option>
                                                    @endforeach

                                                </select>

                                                @elseif(in_array( $ticket_field['type'] ,['select','checkbox','radio']) &&  Arr::has($ticket_field,'option'))
                                        
                                                @php

                                                  $inputType     =  $ticket_field['type'];
                                                  $inputname     =  "ticket_data[$field_name][]";

                                                  $isMultiple    =  Arr::get($ticket_field,'multiple' ,$no);

                                                  if($isMultiple == $no)  $inputname =   "ticket_data[$field_name]";

                                        
                                                
                                                @endphp

                                               @if($inputType ==  'select')
                                                    <select id="{{ $loop->index }}"
                                                        {{ $ticket_field['required'] == $yes ? 'required' : '' }}
                                                        name="{{ $inputname }}" {{   $isMultiple == $yes ? "multiple" :"" }}  class="input-select" >

                                                        <option disabled value="">{{ $ticket_field['placeholder'] }}</option>

                                                        @foreach ($ticket_field['option'] as $key => $option)
                                                            <option value="{{ @$ticket_field['option_value'][$key] }}" >
                                                                {{ $option }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                @elseif($inputType ==  'checkbox')

                                                    <div id="{{ $loop->index }}"
                                                        {{ $ticket_field['required'] == $yes ? 'required' : '' }}>

                                                        @foreach ($ticket_field['option'] as $key => $option)
                                                           @php 
                                                              $id =  rand(10,2000);
                                                           @endphp
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ @$ticket_field['option_value'][$key] }}" id="{{ $id }}" name="ticket_data[{{$field_name}}][]">

                                                                <label class="form-check-label" for="{{ $id }}">
                                                                    {{ $option }} 
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                @else

                                                        <div id="{{ $loop->index }}"
                                                            {{ $ticket_field['required'] == $yes ? 'required' : '' }}>
    
                                                            @foreach ($ticket_field['option'] as $key => $option)
                                                                @php 
                                                                   $id =  rand(2001,400000);
                                                                @endphp
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="ticket_data[{{ $field_name}}]" id="{{ $id }}" value="{{@$ticket_field['option_value'][$key]}}">
    
                                                                    <label class="form-check-label" for="{{$id}}" {{ old('ticket_data.' . $field_name) == $ticket_field['option_value'][$key] ? 'selected' : '' }}>
                                                                        {{ $option }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>


                                                @endif

                                        @elseif($ticket_field['type'] == 'textarea')

                                             <div class="text-editor-area">
                                                    <textarea class="form-control summernote" id="{{$loop->index}}" {{$ticket_field['required'] ==   $yes ? "required" :""}}  name="ticket_data[{{ $field_name }}]"id="text-editor" cols="30" rows="10" placeholder="{{$ticket_field['placeholder']}}">
                                                        {{old('ticket_data.'.$field_name)}}
                                                    </textarea>

                                                    @if(site_settings("open_ai")  ==  App\Enums\StatusEnum::true->status())

                                                        <button type="button" class="ai-generator-btn mt-3 ai-modal-btn" >
                                                            <span class="ai-icon btn-success waves ripple-light">
                                                                    <span class="spinner-border d-none" aria-hidden="true"></span>

                                                                    <i class="ri-robot-line"></i>
                                                            </span>

                                                            <span class="ai-text">
                                                                {{translate('Generate With AI')}}
                                                            </span>
                                                        </button>

                                                    @endif
                                             </div>

                                        @elseif($ticket_field['type'] == 'file')

                                                <div class="upload-filed">
                                                    <input class="form-control" id="{{$loop->index}}" {{$ticket_field['required'] ==   $yes ? "required" :""}} multiple  type="file" name="ticket_data[{{ $field_name }}][]">
                                                    <label for="{{$loop->index}}">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <span class="upload-drop-file">
                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 128 128" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path fill="#f6f0ff" d="M99.091 84.317a22.6 22.6 0 1 0-4.709-44.708 31.448 31.448 0 0 0-60.764 0 22.6 22.6 0 1 0-4.71 44.708z" opacity="1" data-original="#f6f0ff" class=""></path><circle cx="64" cy="84.317" r="27.403" fill="#000" opacity="1" data-original="#000" class=""></circle><g fill="#f6f0ff"><path d="M59.053 80.798v12.926h9.894V80.798h7.705L64 68.146 51.348 80.798zM68.947 102.238h-9.894a1.75 1.75 0 0 1 0-3.5h9.894a1.75 1.75 0 0 1 0 3.5z" fill="#f6f0ff" opacity="1" data-original="#f6f0ff" class=""></path></g></g></svg>
                                                            </span>

                                                        </div>
                                                    </label>
                                                </div>

                                                <ul class="file-list"></ul>

                                            @else

                                            @php
                                                $value =  old('ticket_data.'.$field_name);
                                            @endphp

                                            <input class="form-control"  id="{{$loop->index}}" {{$ticket_field['required'] == $yes ? "required" :""}} type="{{$ticket_field['type']}}" name="ticket_data[{{ $field_name }}]" value="{{$value}}"  placeholder="{{$ticket_field['placeholder']}}">
                                            @endif

                                        </div>
                                    </div>
                                @endif


                        @endforeach

                        <div class="col-12">
                            <div class="text-start">
                                <button type="submit" class="btn btn-success">
                                    {{translate('Create')}}
                                </button>

                             </div>



                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('script-include')

	<script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
	<script src="{{asset('assets/global/js/editor.init.js')}}"></script>

@endpush


@push('script-push')

<script>
    "use strict";

     $(".select-user").select2({
          tags: true,
          tokenSeparators: [','],
      })

      $(".input-select").select2({

      })

      $(document).on("click",'.audience-tab',function(e){
          $('.instraction-note').html($(this).attr('data-note'))
      })


            //file upload and preview

            var uploadedFiles = []; //
          $(".upload-filed input").on("change", function() {
                var fileInput = this;
                uploadedFiles = convertFileListToArray(uploadedFiles) ;
                var preview = $(".file-list");

                function handleFileUpload(file) {
                    var reader = new FileReader();
                    uploadedFiles.push(file);

                    reader.onload = function(e) {

                        preview.append(`<li><span class="remove-list pointer"><i data-name="${file.name}" class="remove-file ri-close-line"></i></span> <p>${file.name}</p> </li>`);

                    };

                    reader.readAsDataURL(file);

                }

                $(this.files).each(function(i, file) {
                    handleFileUpload(file);
                });


                uploadedFiles = createFileList(uploadedFiles);
                fileInput.files = uploadedFiles;

                preview.on("click", ".remove-file", function() {

                    var fileName = $(this).data("name");
                    $(this).parent().parent().remove();

                    var selectedFiles = Array.from(uploadedFiles);

                    selectedFiles = selectedFiles.filter(function(file) {

                        return file.name != fileName;

                    });



                    var newFileList = new DataTransfer();
                    selectedFiles.forEach(function(file) {
                        newFileList.items.add(file);
                    });

                    uploadedFiles   = newFileList.files
                    fileInput.files = newFileList.files;

                });
            });



          function createFileList(blobs) {
              const dataTransfer = new DataTransfer();
              blobs.forEach(blob => {
                  const file = new File([blob], blob.name);
                  dataTransfer.items.add(file);
              });
              return dataTransfer.files;
          }


          function convertFileListToArray(fileList) {

              var filesArray = [];
              for (var i = 0; i < fileList.length; i++) {
                  filesArray.push(fileList[i]);
              }
              return filesArray;
          }

  </script>

@endpush







