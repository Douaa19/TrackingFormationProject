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
                                {{translate('Create Trigger')}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.trigger.store')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4 pb-3">

                        <div class="col-lg-12">
                            <div>
                                <label class="form-label" for="name">
                                    {{translate('Name')}}

                                      <span class="text-danger"> *</span>
                                </label>

                                <input required type="text" name="name" id="name" class="form-control"  placeholder="{{translate("Enter Name")}}"
                                    value="{{old("name")}}" >
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
                                <textarea placeholder="{{translate('Enter Description')}}" class="form-control" name="description" id="description" cols="30" rows="6">{{old("description")}}</textarea>

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

                               
                                </div>
                            
                            </div>

                             
                        </div>

                        <div class="col-12">
                            <div class="text-end">
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

    $(document).on('change','.condition-type',function(e){

        var conditionCollection =  JSON.parse($(this).find(':selected').attr('data-condition-collection'));
        var inputType           =  ($(this).find(':selected').attr('data-input-type'));
        var isTimeFrame         =  ($(this).find(':selected').attr('data-timeframe'));
        var inputValues         =  ($(this).find(':selected').attr('data-input-values'));
        if(inputValues){
            inputValues = JSON.parse(inputValues);
        }

        var inputParent           = ($(this).closest('.row')).parent();
        var type                  = inputParent.hasClass('any') ? 'any' :'all';

        var selectCondition       = ($(this).closest('.row').find('.select-condition'));
        selectCondition.empty();

        for(var i in conditionCollection){
            selectCondition.append($('<option>', {
                value: conditionCollection[i].name,
                text: conditionCollection[i].display_name
            }));
        }
        var input ='' ;

        if(inputType == 'text'){

            var placeholder = 'Enter value';
            if(isTimeFrame){
                placeholder = 'Enter Hour';
            }
            input  = `<input type="text" required placeholder='${placeholder}'  name="${type}[condition_value][]" class="form-control condition-value">`;
        }else if(inputType == 'select'){
            var options = '';
            for(var i in inputValues){
                options += `<option value="${i}"> 
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

                html  += `<div class="mt-2"><select required class="form-select" name="action_values[${dataInputKey}][${inputValues[i].name}][]]">
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







