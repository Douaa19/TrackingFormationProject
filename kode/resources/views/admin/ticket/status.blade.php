

@foreach($ticketStatus as $status)


    <li class="nav-item" role="presentation">
        <a data-status ="{{$status->id}}" class="nav-link status-filter-btn {{$status_active == $status->id ? 'active' :"" }}"   id="{{$status->name}}" >
            {{$status->name}} <span class="badge bg-danger ms-1   rounded-pill">{{ $status->total_ticket }}</span>
        </a>
    </li>
       

@endforeach


