@extends('admin.layouts.master')


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
                            <li class="breadcrumb-item"><a href="{{route('admin.trigger.list')}}">
                                {{translate('Triggers')}}
                            </a></li>
                            <li class="breadcrumb-item active">
                                {{translate('Update')}}
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
                                {{translate('Update Trigger')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                
                <form action="{{route('admin.trigger.update')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4 pb-3">
                        <input type="hidden" name="id" value="{{$trigger->id}}">
                        
                        <div class="col-lg-12">
                            <div>
                                <label class="form-label" for="name">
                                    {{translate('Name')}}
                                      <span class="text-danger"> *</span>
                                </label>

                                <input required type="text" name="name" id="name" class="form-control"  placeholder="{{translate("Enter Name")}}"
                                    value="{{$trigger->name}}" >
                                <span class="text-danger">
                                     {{translate("Must Be Unique")}}
                                </span>

                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div>
                                <label class="form-label" for="description">
                                    {{translate('Description')}}
                                </label>
                                <textarea placeholder="{{translate('Enter Description')}}" class="form-control" name="description" id="description" cols="30" rows="6">{{$trigger->description}}</textarea>

                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div>
                                <h6 class=" border-btm-1 pb-1">
                                    {{translate('Meet')}} <span class="text-danger"> {{translate("All")}} </span> {{translate("the following conditions")}}
                                </h6>

                                <button data-parent ='all' type="button" class="add-new-condition btn btn-outline-success waves-effect waves-light shadow-none"><i
									class="ri-add-line align-bottom me-1"></i>{{translate('Add Condition')}}</button>

                             
                                <div class="all pt-2">
                                    @php
                                       $conditionValues =  (array)@$trigger->all_condition->condition_value;
                                       $dbConditions    =  (array)@$trigger->all_condition->conditions;

                                    @endphp
                
                                    @foreach ((array)@$trigger->all_condition->condition_type as $index =>  $type )

                                              
                                                @php
                                                    $conditionValue      = Arr::get($conditionValues,$index,null);
                                                    $dbCondition         = Arr::get($dbConditions,$index,null);
                                                    $conditionOptions    = getConditionOperator($type,$trigger_configs);
                                                    $conditonInputType   = getConditionInputs($type,$trigger_configs);
                                
                                                @endphp
                                        <div class="row g-2 align-items-start  mb-2">
                                            
                                                <div class="col-lg-3">
                                                    <select required class="form-select condition-type" name="all[condition_type][]">
                                                        <option value="">
                                                            {{translate('Select Type')}}
                                                        </option>

                                                        @foreach (Arr::get($trigger_configs,'conditions',[]) as  $key => $conditions)
                                            
                                                            <optgroup label="{{ k2t($key) }}">
                                        
                                                                @foreach ($conditions as $cKey => $value  )
                                                                    @php
                                                                        $operators           = collect(Arr::get($trigger_configs,'operators',[]));
                                                                        $conditionCollection = collect($operators->only($value['operators'])->all());
                                                                        $inputType           = (Arr::get($value,'type','text'));
                                                                        $inputValues         = (Arr::get($value,'values',null));
                                                                      
                                                                    @endphp
                                                                <option  data-condition = '{{$dbCondition}}'   @if( $type  ==  $cKey) data-select = "{{ $conditionValue}}"   selected @endif data-input-type='{{   $inputType }}'  data-input-values='{{$inputValues ? collect($inputValues ) : null}}' data-condition-collection = "{{$conditionCollection}}" value="{{$cKey}}">
                                                                        {{k2t($cKey)}}
                                                                </option>
                                                                @endforeach
                                        
                                                            </optgroup>
                                                        
                                                        @endforeach
                                                    </select>
                                                </div>
                        
                                               
                                               
                                         
                                            <div class="col-lg-3">
                                                <select required class="form-select select-condition" name="all[conditions][]">
                                         
                                                    @foreach ($conditionOptions as $conditionsValue)
                                                        <option {{Arr::get($conditionsValue,'name',null)  == $dbCondition ? 'selected' :""}} value=" {{Arr::get($conditionsValue,'name',null)}}">
                                                            {{Arr::get($conditionsValue,'display_name',null)}}
                                                        </option> 
                                                    @endforeach

                                                </select>
                                            </div>
                                    
                                            <div class="col-lg-3 condition-value-section">


                                                @if(Arr::get($conditonInputType,'type',null) == 'select')
                                                      <select class="form-select" name="all[condition_value][]" >

                                                          @foreach (Arr::get($conditonInputType,'values',[]) as $id => $name)
                                                               <option {{ $conditionValue == $id ? "selected" :"" }} value="{{ $id }}">
                                                                   {{$name}}
                                                               </option>
                                                          @endforeach

                                                      </select>
                                                      
                                                @else
                                                   <input type="text" value="{{ $conditionValue }}" required placeholder="{{translate('Enter Value')}}" name="all[condition_value][]" class="form-control condition-value">
                                                @endif
                                            </div>
                                        
                                        
                                            <div class="col-lg-3">
                                                <a  class="fs-20 link-danger add-btn waves ripple-light remove-option"> <i class="ri-delete-bin-line"></i></a>
                                            </div>
                                    
                                        </div>
                                    @endforeach
    

                                </div>
                            
                            </div>

                             
                        </div>


                        <div class="col-lg-12">
                            <div>
                                <h6 class=" border-btm-1 pb-1">
                                    {{translate('Meet')}} <span class="text-danger"> {{translate("Any")}} </span> {{translate("the following conditions")}}
                                </h6>

                                <button data-parent ='any' type="button" class="add-new-condition btn btn-outline-success waves-effect waves-light shadow-none"><i
									class="ri-add-line align-bottom me-1"></i>{{translate('Add Condition')}}</button>

                             
                             

                                 <div class="any pt-2">
                                    @php
                                       $conditionValues =  (array)@$trigger->any_condition->condition_value;
                                       $dbConditions    =  (array)@$trigger->any_condition->conditions;

                                    @endphp
                
                                    @foreach ((array)@$trigger->any_condition->condition_type as $index =>  $type )

                                              
                                                @php
                                                    $conditionValue      = Arr::get($conditionValues,$index,null);
                                                    $dbCondition         = Arr::get($dbConditions,$index,null);
                                                    $conditionOptions    = getConditionOperator($type,$trigger_configs);
                                                    $conditonInputType   = getConditionInputs($type,$trigger_configs);
                                
                                                @endphp
                                        <div class="row g-2 align-items-start  mb-2">
                                            
                                                <div class="col-lg-3">
                                                    <select required class="form-select condition-type" name="any[condition_type][]">
                                                        <option value="">
                                                            {{translate('Select Type')}}
                                                        </option>

                                                        @foreach (Arr::get($trigger_configs,'conditions',[]) as  $key => $conditions)
                                            
                                                            <optgroup label="{{ k2t($key) }}">
                                        
                                                                @foreach ($conditions as $cKey => $value  )
                                                                    @php
                                                                        $operators           = collect(Arr::get($trigger_configs,'operators',[]));
                                                                        $conditionCollection = collect($operators->only($value['operators'])->all());
                                                                        $inputType           = (Arr::get($value,'type','text'));
                                                                        $inputValues         = (Arr::get($value,'values',null));
                                                                      
                                                                    @endphp
                                                                <option  data-condition = '{{$dbCondition}}'   @if( $type  ==  $cKey) data-select = "{{ $conditionValue}}"   selected @endif data-input-type='{{   $inputType }}'  data-input-values='{{$inputValues ? collect($inputValues ) : null}}' data-condition-collection = "{{$conditionCollection}}" value="{{$cKey}}">
                                                                        {{k2t($cKey)}}
                                                                </option>
                                                                @endforeach
                                        
                                                            </optgroup>
                                                        
                                                        @endforeach
                                                    </select>
                                                </div>
                        
                                               
                                               
                                         
                                            <div class="col-lg-3">
                                                <select required class="form-select select-condition" name="any[conditions][]">
                                         
                                                        @foreach ($conditionOptions as $conditionsValue)
                                                            <option {{Arr::get($conditionsValue,'name',null)  == $dbCondition ? 'selected' :""}} value=" {{Arr::get($conditionsValue,'name',null)}}">
                                                                {{Arr::get($conditionsValue,'display_name',null)}}
                                                            </option> 
                                                        @endforeach
                                                    
                                                  
                                                </select>
                                            </div>
                                    
                                            <div class="col-lg-3 condition-value-section">


                                                @if(Arr::get($conditonInputType,'type',null) == 'select')
                                                      <select class="form-select" name="any[condition_value][]" >

                                                          @foreach (Arr::get($conditonInputType,'values',[]) as $id => $name)
                                                               <option {{ $conditionValue == $id ? "selected" :"" }} value="{{ $id }}">
                                                                   {{$name}}
                                                               </option>
                                                          @endforeach

                                                      </select>
                                                      
                                                @else
                                                   <input type="text" value="{{ $conditionValue }}" required placeholder="{{translate('Enter Value')}}" name="any[condition_value][]" class="form-control condition-value">
                                                @endif
                                            </div>
                                        
                                        
                                            <div class="col-lg-3">
                                                <a class="fs-20 link-danger add-btn waves ripple-light remove-option"> <i class="ri-delete-bin-line"></i></a>
                                            </div>
                                    
                                        </div>
                                    @endforeach
    

                                </div>
                            
                            </div>

                             
                        </div>


                        <div class="col-lg-12">
                            <div>
                                <h6 class=" border-btm-1 pb-1">
                                    {{translate('Perform these actions')}} 
                                </h6>

                                <button data-parent ='actions' type="button" class="add-new-action btn btn-outline-success waves-effect waves-light shadow-none"><i
									class="ri-add-line align-bottom me-1"></i>{{translate('Add Action')}}</button>

                       
                                <div class="actions pt-2">
                        
                        


                                    @foreach ($trigger->actions as $triggerkey =>  $triggerValues )

                                                @php
                                                    $inputs = getTriggerAction($triggerkey,$trigger_configs);
                                                @endphp


                                                @foreach ($triggerValues as $key => $triggerValue )

                                                     @php
                                                        if(in_array($triggerkey,['send_sms_to_agent', 'send_email_to_agent', 'send_email_to_user'])){
                                                            if(count($triggerValues->message) == 1 && $loop->index == 1){
                                                                break;
                                                            }
                                                        }
                                                     @endphp

        
                                                    <div class="row g-2 align-items-start  mb-2">
                                                
                                                        <div class="col-lg-3">
                                                            <select required class="form-select action-type" name="actions[]">
                                                                <option value="">
                                                                    {{translate('Select Action')}}
                                                                </option>
                                                                @foreach (Arr::get($trigger_configs,'actions',[]) as  $action)
                                                
                                                                    @php
                                                                        $actionInputs = Arr::get($action,'inputs',null);
                                                                    @endphp
                                                
                                                                    <option {{$triggerkey == Arr::get($action,'name') ? 'selected' :'' }} data-key= "{{Arr::get($action,'name')}}" data-inputs = "{{$actionInputs ? collect($actionInputs) : null}}" value="{{Arr::get($action,'name')}}">
                                                                        {{Arr::get($action,'display_name')}}
                                                                    </option>
                                                                    
                                                                @endforeach
                                                
                                                            </select>


                                                    
                                                            @if($inputs && $triggerValue)
                                                    
                                                    
                                                                <div class="action-inputs mt-2">

                                                               

                                                            
                                                                    @foreach ($inputs as $index => $input )
                                                                    
                                                            
                                                                            @php
                                                                                $type            = Arr::get($input , 'type' , null);
                                                                                $name            = Arr::get($input , 'name' , null);
                                                                                $placeholder     = Arr::get($input , 'placeholder' , null);
                                                                                $values          = Arr::get($input , 'values' , null);

                                                                            
                                                                                $inputVal        =  is_array($triggerValue) 
                                                                                                    ? Arr::get($triggerValues->{$name},$loop->parent->index) 
                                                                                                    : $triggerValue ;
                                                                            @endphp


                                                                            @if($type ==  'select')

                                                                                <div class="mt-2">
                                                                                    <select required class="form-select" name="action_values[{{$triggerkey}}][{{$name}}][]">
                                                                                        
                                                                                        @foreach (  $values as $k => $val )
                                                                                            <option {{ @$inputVal  == $k ? "selected" :""}}  value="{{$k}}">
                                                                                                {{$val}}
                                                                                            </option>
                                                                                        @endforeach
                                                                                        
                                                                                                    
                                                                                    </select>
                                                                                </div>
                                                                            
                                                                            @elseif($type ==  'text')

                                                                                <div class="mt-2">

                                                                                    <input type="text" value="{{ @$inputVal }}"  class="form-control" required  placeholder="{{$placeholder}}"
                                                                                    name="action_values[{{$triggerkey}}][{{$name}}][]" >

                                                                                </div>

                                                                            @elseif($type ==  'textarea')

                                                                                <div class="mt-2">

                                                                                    <textarea placeholder="{{$placeholder }}" required class="form-control" name="action_values[{{$triggerkey}}][{{$name}}][]" cols="30" rows="6">{{ @$inputVal}}</textarea>

                                                                                </div>

                                                                            @endif


                                                                    @endforeach
                                                                
                                                                </div>
                                                            @endif
                                                    
                                                        </div> 

                                                        <div class="col-lg-3">
                                                            <a  class="fs-20 link-danger add-btn waves ripple-light remove-option"> <i class="ri-delete-bin-line"></i></a>
                                                        </div>

                                                        <hr>
                                                    </div>

                                                @endforeach
                                
                                      
                                    @endforeach
                                     
                                       
                   
                        

                                </div>
                            
                            </div>

                             
                        </div>

                        <div class="col-12">
                            <div class="text-s">
                                <button type="submit" class="btn btn-success">
                                    {{translate('Update')}}
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

   $(".condition-type").select2({
        placeholder:"{{translate('Select Type')}}",
        tags: true,
        tokenSeparators: [','],
   })

    $(document).on('change','.condition-type',function(e){

        var conditionCollection   =  JSON.parse($(this).find(':selected').attr('data-condition-collection'));
        var inputType             =  ($(this).find(':selected').attr('data-input-type'));
        var inputValues           =  ($(this).find(':selected').attr('data-input-values'));
        var selectedValue         =  ($(this).find(':selected').attr('data-select'));
        var selectedCondition     =  ($(this).find(':selected').attr('data-condition'));
        if(inputValues){
            inputValues           = JSON.parse(inputValues);
        }

        var inputParent           = ($(this).closest('.row')).parent();
        var type                  = inputParent.hasClass('any') ? 'any' :'all';

        var selectCondition       = ($(this).closest('.row').find('.select-condition'));
        selectCondition.empty();



        for(var i in conditionCollection){

            selectCondition.append(`<option value ='${conditionCollection[i].name}' ${conditionCollection[i].name ==  selectedCondition ? "selected" :""}> ${conditionCollection[i].display_name} </option>`);
        }



        var input ='' ;

        if(inputType == 'text'){
            input  = `<input type="text" required placeholder='Enter value' value="${selectedValue ?? ''}"  name="${type}[condition_value][]" class="form-control condition-value">`;
        }else if(inputType == 'select'){
            var options = '';
            for(var i in inputValues){
                options += `<option ${i == selectedValue ? 'selected' : ''} value="${i}"> 
                                ${inputValues[i]}
                           </option>`
            }

            input  = `<select required class="form-select" name="${type}[condition_value][]">
                         ${   options }                       
                      </select>`;
        }

        if( input != ''){
            $(($(this).closest('.row').find('.condition-value-section'))).html( input)
        }

    });


    $(document).on('change','.action-type',function(e){

        var inputValues         =  ($(this).find(':selected').attr('data-inputs'));
        var dataInputKey        =  ($(this).find(':selected').attr('data-key'));
        if(inputValues){
            inputValues = JSON.parse(inputValues);
        }
  
        var html = '';
        for(var i in inputValues){
 
            if(inputValues[i].type == 'textarea'){
                html +=`    <div class="mt-2">
                                <textarea placeholder="${inputValues[i].placeholder}" required class="form-control" name="action_values[${dataInputKey}][${inputValues[i].name}][]" id="description" cols="30" rows="6"></textarea>
                            </div>`
            }
            else if(inputValues[i].type == 'text'){
                html +=`<div class="mt-2">
                             <input type="text"  class="form-control" required  placeholder="${inputValues[i].placeholder}"
                             name="action_values[${dataInputKey}][${inputValues[i].name}][]" >
                        </div>`
            }
            else if(inputValues[i].type == 'select'){


                var options = '';
                for(var j in inputValues[i].values){
                    options += `<option value="${j}"> 
                                    ${(inputValues[i].values)[j]}
                            </option>`
                }

                html  += `<div class="mt-2"><select required class="form-select" name="action_values[${dataInputKey}][${inputValues[i].name}][]">
                             ${   options }                       
                         </select></div>`;
               
            }

        }


        $(($(this).closest('.row').find('.action-inputs'))).html( html)
        
    });

    $(document).on('click','.add-new-condition',function(e){
        var parent  = $(this).attr("data-parent");
        $(this).find(".note-btn-spinner").remove();
        $(this).append(`<div class="ms-1 spinner-border spinner-border-sm text-dark note-btn-spinner " role="status">
                <span class="visually-hidden"></span>
            </div>`);
        addOption(parent)
        e.preventDefault();
    })


    function addOption(parent ){

        $.ajax({
                    method:'get',
                    url: "{{route('admin.trigger.add.conditon')}}",
                    data:{
                        'type' :parent,
   
                    },
                    dataType: 'json',
                    success: function (response) {
                        $(`.${parent}`).append(response.html)
                        $(".condition-type").select2({
                            placeholder:"{{translate('Select Type')}}",
                            tags: true,
                            tokenSeparators: [','],
                        })
                      
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
                    },
                    complete: function() {

                      $('.add-new-condition').find(".note-btn-spinner").remove()
                      $('.add-new-action').find(".note-btn-spinner").remove()
                    },
        })
    }

    $(document).on('click','.add-new-action',function(e){
        var parent  = $(this).attr("data-parent");
        $(this).find(".note-btn-spinner").remove();
        $(this).append(`<div class="ms-1 spinner-border spinner-border-sm text-dark note-btn-spinner " role="status">
                <span class="visually-hidden"></span>
            </div>`);
        addOption(parent)
        e.preventDefault();
    });

    $(document).on('click','.remove-option',function(e){

        ($(this).parent()).parent().remove();  

        e.preventDefault()
    })

  

 </script>
@endpush







