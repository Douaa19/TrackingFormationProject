@php
    $payload =  $ticket->envato_payload;
    $item    =  @$payload->item; 

@endphp

<div class="container-fluid p-4 border mb-4 ">

    <h4 class="border-bottom mb-4 pb-3">
        {{translate("Envato verification")}}
    </h4>

    @if($payload && $item)
        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-n4 mx-n4">
                    <div class="bg-warning-subtle">
                        <div class="card-body pb-0 px-4">
                            <div class="row mb-3">
                                <div class="col-md">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-auto">
                                            <div class="avatar-md">
                                                <div class="avatar-title bg-white rounded-circle">
                                                    <img src="{{$item->previews->icon_preview->icon_url}}" alt="Project icon" class="avatar-xs">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div>
                                                <h4 class="fw-bold"> {{  $item->name }}</h4>
                                                <div class="hstack gap-3 flex-wrap">
                                                    <div><i class="ri-building-line align-bottom me-1"></i> 
                                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="{{translate('Author')}}" target="_blank" href="{{$item->author_url}}">
                                                            {{ $item->author_username  }}
                                                        </a>
                                                    </div>
                                                    <div class="vr"></div>
                                                    <div>{{ translate('Last update') }} : <span class="fw-medium"> {{ get_date_time($item->updated_at)  }}</span></div>
                                                    <div class="vr"></div>
                                                    <div>
                                                        <a target="_blank" href="{{$item->url }}" class=" btn btn-sm btn-success fs-16 ">
                                                            {{ translate('View item') }}
                                                        </a>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>

                            <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-semibold active" data-bs-toggle="tab" href="#project-overview" role="tab" aria-selected="true">
                                        {{translate('Overview')}}
                                    </a>
                                </li>
                            
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-team" role="tab" aria-selected="false" tabindex="-1">
                                        {{translate('Item details')}}
                                    </a>
                                </li> 
                            </ul>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content text-muted">
                    <div class="tab-pane fade active show" id="project-overview" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Buyer") }}    <span class="badge bg-success"> {{$payload->buyer }} </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Total purchase") }}    <span class="badge bg-success"> {{$payload->purchase_count }} </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Amount") }}    <span class="badge bg-success"> {{$payload->amount}}$ </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Support amount") }}    <span class="badge bg-success"> {{$payload->support_amount}}$ </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Sold at") }}    <span class="badge bg-success"> {{ get_date_time($payload->sold_at) }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Purchase key") }}    <span class="badge bg-info"> {{$payload->purchase_key}}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("License") }}    <span class="badge bg-success"> {{$payload->license }} </span>
                                            </li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                
                                                {{ translate("Support type") }}    @if($ticket->is_support_expired == 1) 
                                                                                        <span class="badge bg-danger"> {{ translate('Expired')  }} 
                                                                                        </span> 
                                                                                    @else 
                                                                                        <span class="badge bg-secondary"> {{ translate('Valid')  }} 
                                                                                        </span> 
                                                                                    @endif
                                            </li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                @php
                                    
                                                        if($payload->supported_until){
                                                            $supported_until   = \Carbon\Carbon::parse($payload->supported_until);
                                                            $expiredDate       = $supported_until->format('l, F j, Y \a\t g:i A');
                                                        }
                                        
                                                @endphp
                                                {{ translate("Support until") }}    @if($payload->supported_until) 
                                                                                    <span class="badge bg-success"> {{$expiredDate}} </span> 
                                                                                    @else 
                                                                                    <span>  N/A </span> 
                                                                                    @endif
                                            </li>

                                            
                                        </ul>
                                        
                                        <a href="{{route('admin.ticket.sync.purchase',$ticket->ticket_number)}}" class="btn btn-md btn-danger w-25 text-center mt-3 mb-3 justify-content-center">
                                            {{translate("Sync purchase")}} <i class="ri-refresh-line align-bottom "></i>
                                        </a>
        
                                    </div>
                                    
                                
                                </div>
                            </div>
                        

                        </div>
        
                    </div>


                    <div class="tab-pane fade" id="project-team" role="tabpanel">
                

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <ul class="list-group">

                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Author") }}    <a target="_blank" href="{{$item->author_url }}"> {{$item->author_username }}</a> 
                                            </li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Name") }}      <a target="_blank" href="{{$item->url }}"> {{$item->name }}</a>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("No. of sell") }}    <span class="badge bg-success"> {{$item->number_of_sales }} </span>
                                            </li>
                                
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Published at") }}    <span class="badge bg-success"> {{ get_date_time($item->published_at) }} </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Last update") }}    <span class="badge bg-success"> {{ get_date_time($item->updated_at) }} </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Price") }}    <span class="badge bg-success"> {{ round($item->price_cents/100,2)}}$ </span>
                                            </li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Rating") }}    <span class="badge bg-success"> {{ ($item->rating)}} <i class="ri-star-s-fill"></i> </span>
                                            </li>
                                        
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Total review") }}    <span class="badge bg-success"> {{ ($item->rating_count)}} </span>
                                            </li>
                                        

                                                
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ translate("Trednding") }}    
                                                <span class="badge  {{$item->trending ? 'bg-success': 'bg-danger' }}  "> {{ ($item->trending ? "Yes" : 'No')}} 

                                                </span>
                                            </li>
                                        
                                        

                                            
                                        </ul>
                                        
                                
        
                                    </div>
                                    
                                
                                </div>
                            </div>
                        

                        </div>
        
                    </div>
    
                </div>
            </div>

        </div>
    @else

       <div class="row">

          <div class="col-12">

            <div class="card mt-n4 mx-n4">

                <div class="card-body pb-0 px-4">

                     <form action="{{route('admin.ticket.verify.purchase')}}" method="post">
                        @csrf
                          <input type="hidden"  name="id" value="{{$ticket->id}}">
                            <div>
                                <input type="text" name="purchase_key" id="purchase_key" placeholder="{{translate('Enter purchase key')}}" class="form-control">
                            </div>
                          <div>
                            <button class="btn btn-md btn-success w-25 text-center mt-3 mb-3 justify-content-center">
                                {{translate("Verify purchase")}} <i class="ri-refresh-line align-bottom "></i>
                            </button>
                          </div>
                     </form>
                </div>

            </div>

          </div>

       </div>

    @endif

</div>