

   
   @foreach ($ticketSettings as $ticketInput)

        <div class="col-lg-4 col-md-6 col-12 dragable-item dragable-card">
            <div id="cardNo{{ $loop->index }}" class="card config-card">

                <input class="card-index" hidden name="card_index[]" value="{{$ticketInput['name']}}">
    

                <div class="mb-4 ">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">
                                    {{translate('Label')}}  : {{ $ticketInput['labels'] }}
                                </h5>
                            </div>
                        </div>
    
                        <div class="col-sm-auto">
                            <i data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                            title="{{translate("Drag the card in any section")}}"  class=" ri-drag-move-2-fill fs-21 text-dark"></i>
                        </div>
    
                    </div>
                </div>

                <ul class="config-list">
                    <li><span>  
                          
                        {{translate('Type')}}
                    
                    </span><span>{{ ucfirst($ticketInput['type']) }}</span></li>
                    <li><span>
                          {{translate("Width")}}
                        </span><span>
                            @php
                                 $enum   =   Arr::get(@$ticketInput,'width',"COL_12") ;
                                 $width = Arr::get(App\Enums\FieldWidth::toArray(), $enum);

                            @endphp
                            {{ $width }}%
                        </span></li>
                    <li><span>
                        
                      {{translate("Mandatory")}}
                    </span><span> {{ $ticketInput['required'] == App\Enums\StatusEnum::true->status() ? 'Yes' : 'No' }}</span></li>
                    <li><span>
                        
                      {{translate("Placeholder")}}
                     </span><span>{{ $ticketInput['placeholder'] }}</span></li>
                </ul>

                <div class="hstack gap-3">
                    <a href="javascript:void(0);" class="edit-option fs-18 link-warning"
                        data-name={{ $ticketInput['name'] }}>
                        <i class="ri-pencil-fill"></i></a>


                    @if ($ticketInput['default'] == App\Enums\StatusEnum::false->status())
                        <a href="javascript:void(0);"
                            data-href="{{ route('admin.setting.ticket.input.delete', $ticketInput['name']) }}"
                            class="delete-ticket-item fs-18 link-danger">
                            <i class="ri-delete-bin-line"></i></a>
                    @endif

                </div>

            </div>
        </div>
    @endforeach
</form>