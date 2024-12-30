@extends($layout)
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

			<div class="card-body">
                <div class="list-group">
                        @foreach($notifications as $notification)
                            @php
                                $data = $notification->data ? json_decode($notification->data,true) :[];
                            @endphp
                            @if(isset($data['route']))
                                <a href="javascript:void(0);" id="{{$notification->id}}" data-href= "{{($data['route'])}}"   class=" read-notification list-group-item list-group-item-action ">
                                
                                    <div class="d-flex mb-2 align-items-center">
                                        <div class="flex-shrink-0">
                                            @if($notification->admin)
                                                <img src="{{getImageUrl(getFilePaths()['profile']['admin']['path'].'/'.$notification->admin->image,getFilePaths()['profile']['admin']['size'])}}"
                                                class="avatar-sm rounded-circle" alt="{{$notification->admin->image}}">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="list-title fs-15 mb-1">   {{$notification->admin? $notification->admin->name : 'N/A'}}</h5>
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
                        @endforeach
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








