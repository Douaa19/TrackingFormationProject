@extends($layout)
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">
						{{translate('All Notifications')}}
					</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{request()->routeIs('admin.*') ?  route('admin.dashboard') : route('user.dashboard')}}">
								{{translate('Home')}}
							</a></li>
							<li class="breadcrumb-item active">
								{{translate('Notification')}}
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
								{{translate('All Notifications')}}
							</h5>
						</div>
					</div>

                    @if($notifications->count() > 0)
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a href="{{route('admin.clear.notification')}}" class="btn btn-danger add-btn waves ripple-light">
                                        <i class="ri-delete-bin-4-line  me-1"></i>
                                    {{translate('Clear all')}}
                                </a>
                            </div>
                        </div>
                    @endif

				</div>
			</div>

			<div class="card-body">
                <div class="list-group">
                

                      @forelse($notifications as $notification)
                            @php
                                 $data = $notification->data ? json_decode($notification->data,true) :[];
                            @endphp
                        @if(isset($data['route']))

                            <a href="javascript:void(0);" id="{{$notification->id}}" data-href= "{{($data['route'])}}"   class=" read-notification list-group-item list-group-item-action ">

                                <div class="d-flex mb-2 align-items-center">

                                    <div class="flex-shrink-0">
                                        @php
                                           $imgUlr = route('default.image',"150x150");
                                            if($notification->admin){
                                                $imgUlr = getImageUrl(getFilePaths()['profile']['admin']['path'].'/'.$notification->admin->image,getFilePaths()['profile']['admin']['size']);
                                            }
                                            elseif($notification->user){
                                                $imgUlr = getImageUrl(getFilePaths()['profile']['user']['path'].'/'.$notification->user->image,getFilePaths()['profile']['user']['size']);  
                                            }
                                        @endphp
                                      
                                            <img src="{{$imgUlr}}"
                                            class="avatar-sm rounded-circle" alt="profile.jpg">
                                       
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="list-title fs-15 mb-1">  
                                            @if($notification->admin)
                                              {{$notification->admin->name}}
                                            @elseif($notification->user)
                                                {{$notification->user->name}}
                                            @else
                                                {{translate("N/A")}}
                                            @endif
                                        </h5>
                                        <p class="list-text mb-0 fs-12">   {{getTimeDifference($notification->created_at)}}</p>
                                    </div>
                                </div>
                                <p class="list-text mb-0">    
                                    @if(isset($data['messsage']))
                                      {{$data['messsage']}}
                                    @endif
                                </p>
                            </a>
                            
                        @endif
                     @empty

                        <div class="text-center">
                             
                             {{translate("No notification found")}}

                        </div>
                       
                     @endforelse
                </div>

                <div class="pagination d-flex justify-content-end mt-3 ">
					<nav >
					
							{{$notifications->appends(request()->all())->links()}}
						
					</nav>
				</div>
              
			</div>
          
		</div>
	</div>
@endsection








