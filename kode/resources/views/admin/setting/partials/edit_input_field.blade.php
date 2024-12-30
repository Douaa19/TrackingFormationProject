@php
    $inputTypes = getInputTypes();
    $widths = App\Enums\FieldWidth::toArray();
@endphp
<div class="row g-3">
    <div class="col-xl-12">
        <div class="row">
            <input type="hidden" name="name" value={{ $input->name }}>
            <div class="col-lg-12 ">
                <div class="mb-3">
                    <label class="form-label" for="label">
                        {{ translate('Label') }}
                        <span class="text-danger"> *</span>
                    </label>
                    <input type="text" name="labels" id="label" class="form-control"
                        value="{{ $input->labels }}">

                </div>

                <div class="mb-3">
                    <label class="form-label" for="type">
                        {{ translate('Type') }}
                        <span class="text-danger"> *</span>
                    </label>

                    @if ($input->default == App\Enums\StatusEnum::true->status())
                        <input disabled type="text" name="type" class="form-control"
                            value="{{ $input->type }}">
                        <input hidden type="text" name="type" class="form-control"
                            value="{{  $input->type }}">
                    @else
                        <select class="form-select" name="type" id="type">
                            @foreach ($inputTypes as $type)
                                <option {{ $input->type == $type ? 'selected' : '' }}
                                    value="{{ $type }}">
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>


                        <div  class="option-field">

                            @if (@$input->option && ($input->type == 'select' ||  $input->type == 'checkbox' ||  $input->type == 'radio' ))

                                <div class="row mt-2">

                                    @if($input->type == 'select')

                                        <div class="col mt-2 select-type">
                                            
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"  {{$input->multiple ==  App\Enums\StatusEnum::true->status() ? "checked" : ''   }}   name="multiple" id="multiselect" value="{{App\Enums\StatusEnum::true->status()}}">
                                                <label class="form-check-label" for="multiselect">
                                                    {{translate('Multiple Seclect')}}
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" {{$input->multiple ==  App\Enums\StatusEnum::false->status() ? "checked" : ''   }}  type="radio" name="multiple" id="singleSelect" value="{{App\Enums\StatusEnum::false->status()}}">
                                                <label class="form-check-label" for="singleSelect">
                                                    {{translate("Single Select")}}	
                                                </label>
                                            </div>

                                        </div>
                                        
                                    @endif

                                    <div class="col add-option-section">
                                        <div class="hstack gap-3 mb-3 mt-4 justify-content-end">

                                        <a href="javascript:void(0);" class="add-option fs-18 link-success">
                                                            <i class="ri-add-box-fill"></i></a>
                                        </div>
                                    </div>

                                </div>

                    
                                <div class="mb-3 mt-3 option-field-value">
                                    @foreach ($input->option as $optionKey => $option)
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label" for="optionValue-{{$loop->index}}">
                                                    {{ translate('Option Value') }}
                                                    <span class="text-danger"> *</span>
                                                </label>

                                                <input type="text" id="optionValue-{{$loop->index}}"
                                                    name="option_value[]" class="form-control"
                                                    value="{{@$input->option_value[$optionKey] ?? $option }}">

                                            </div>

                                            <div class="col-5">
                                                <label class="form-label" for="option-{{$loop->index}}">
                                                    {{ translate('Display Name') }}
                                                    <span class="text-danger"> *</span>
                                                </label>

                                                <input type="text" id="option-{{$loop->index}}" name="option[]"
                                                    class="form-control" value="{{ $option }}">

                                            </div>
                                            <div class="col-1 mt-md-4">
                                                <div class="hstack gap-3 mt-3">
                                                    <a href="javascript:void(0);"
                                                        class="delete-option fs-18 link-danger">
                                                        <i class="ri-delete-bin-line"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            
                            @endif

                        </div>
                        

                    @endif


                </div>

                <div class="mb-3">
                    <label class="form-label" for="width">
                        {{ translate('Width') }}
                        <span class="text-danger">*</span>
                    </label>

                    <select class="form-select" name="width">
                        @foreach ($widths as $key => $value)
                            <option
                                    {{@$input->width == $key ? 'selected' : '' }}
                                    value="{{ $key }}">
                                    {{ ucfirst($value) }}%
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">

                    <label class="form-label" for="mandatory_required">
                        {{ translate('Mandatory/Required') }}
                        <span class="text-danger"> *</span>
                    </label>

                    @if ($input->default == App\Enums\StatusEnum::true->status())
                        <input disabled type="text" name="required" class="form-control"
                            value="{{ $input->required == App\Enums\StatusEnum::true->status() ? 'Yes' : 'No' }}">
                        <input hidden type="text" id="mandatory_required" name="required" class="form-control"
                            value="{{ $input->required }}">
                    @else
                        <select class="form-select" name="required" id="mandatory_required">
                            <option
                                {{$input->required == App\Enums\StatusEnum::true->status() ? 'selected' : '' }}
                                value="{{ App\Enums\StatusEnum::true->status() }}">
                                {{ translate('Yes') }}
                            </option>
                            <option
                                {{ $input->required == App\Enums\StatusEnum::false->status() ? 'selected' : '' }}
                                value="{{ App\Enums\StatusEnum::false->status() }}">
                                {{ translate('No') }}
                            </option>
                        </select>
                    @endif

                </div>

                <div class="mb-3">
                    <label class="form-label" for="visibility">
                        {{ translate('Visibility') }}

                        <span class="text-danger"> *</span>

                    </label>

                    @php
                        $visibility = @$input->visibility ?? null ;
                    @endphp

                    <select class="form-select" name="visibility" id="visibility">


                        <option {{ $visibility == App\Enums\StatusEnum::true->status() ? 'selected' : '' }}
                            value="{{ App\Enums\StatusEnum::true->status() }}">
                            {{ translate('Visible') }}
                        </option>
                        <option {{ $visibility == App\Enums\StatusEnum::false->status() ? 'selected' : '' }}
                            value="{{ App\Enums\StatusEnum::false->status() }}">
                            {{ translate('Hidden') }}
                        </option>

                    </select>

                </div>

                <div class="mb-3">
                    <label class="form-label" for="placeholder">
                        {{ translate('Placeholder') }}
                        <span class="text-danger"> *</span>
                    </label>

                    <input type="text" name="placeholder" id="placeholder" class="form-control"
                        value="{{ $input->placeholder}}">

                    <input type="hidden" name="name" class="form-control"
                        value="{{ $input->name }}">

                </div>
            </div>

        </div>
    </div>
</div>
