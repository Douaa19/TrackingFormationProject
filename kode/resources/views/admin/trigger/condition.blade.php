<div class="row g-2 @if($type != 'actions')align-items-center @else align-items-start @endif mb-2">
     
    @if($type != 'actions')
        <div class="col-lg-3">
            <select required class="form-select condition-type" name="{{$type}}[condition_type][]">
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
                        <option @if($key == 'timeframe') data-timeframe = "true" @endif data-input-type='{{   $inputType }}'  data-input-values='{{$inputValues ? collect($inputValues ) : null}}' data-condition-collection = "{{$conditionCollection}}" value="{{$cKey}}">
                                {{k2t($cKey)}}
                        </option>
                        @endforeach

                    </optgroup>
                    
                @endforeach

            </select>
        </div>
        <div class="col-lg-3">
            <select required class="form-select select-condition" name="{{$type}}[conditions][]">
                <option value="">
                    {{translate('Select Condition')}}
                </option>
            </select>
        </div>

        <div class="col-lg-3 condition-value-section">
            <input type="text" required placeholder="{{translate('Enter Value')}}" name="{{$type}}[condition_value][]" class="form-control condition-value">
        </div>
    @else
        <div class="col-lg-3">
            <select required class="form-select action-type" name="actions[]">
                    <option value="">
                        {{translate('Select Action')}}
                    </option>

                    @foreach (Arr::get($trigger_configs,'actions',[]) as  $action)

                        @php
                            $actionInputs = Arr::get($action,'inputs',null);
                        @endphp

                        <option data-key= "{{Arr::get($action,'name')}}" data-inputs = "{{$actionInputs ? collect($actionInputs) : null}}" value="{{Arr::get($action,'name')}}">
                            {{Arr::get($action,'display_name')}}
                        </option>
                        
                    @endforeach

            </select>


            <div class="action-inputs mt-2">
            
            </div>

        </div>
    @endif

    <div class="col-lg-3">
        <a class="fs-20 link-danger add-btn waves ripple-light remove-option"> <i class="ri-delete-bin-line"></i></a>
    </div>
    @if($type == 'actions')
      <hr>
    @endif
</div>
