
    <div class="multi-channel mb-4">

        <h5 class="fs-12 text-uppercase">
            {{translate("Products")}}
        </h5>

        <ul class="list-group">
            <li class="list-group-item ">

                <a href="javascript:void(0)" class="{{!$department_active ? 'active' :""}} mail-list-item d-flex align-items-center ticket-by-department">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 avatar-xs">
                                <div class="avatar-title bg-light rounded p-1">
                                    <img src="{{get_default_image()}}" alt="default.jpg" class="img-fluid">
                                </div>
                            </div>

                            <div class="flex-shrink-0 ms-2">
                                <p class="fs-14 fw-semibold mb-0">
                                    {{translate('All')}}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-shrink-0">
                        <span class="badge badge-soft-primary ms-auto">
                            {{   $totalTicket}}
                        </span>
                    </div>
                </a>

            </li>
            @if(count($departmentCounter) > 0)

                @foreach($departmentCounter as $department)
                    <li class="list-group-item">
                        <a href="javascript:void(0)" data-id  ="{{$department->id}}" class="{{$department->active_class}} mail-list-item d-flex align-items-center ticket-by-department">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar-xs">
                                        <div class="avatar-title bg-light rounded p-1">
                                            <img src="{{$department->imageURL}}" alt="{{$department->name}}" class="img-fluid">
                                        </div>
                                    </div>

                                    <div class="ms-2">
                                        <p class="fs-14 fw-semibold mb-0 line-clamp-1">
                                            {{$department->name}}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-shrink-0">
                                <span class="badge badge-soft-primary ms-auto">
                                    {{$department->total_ticket}}
                                </span>
                            </div>
                        </a>
                    </li>
                @endforeach

            @endif
        </ul>
    </div>
