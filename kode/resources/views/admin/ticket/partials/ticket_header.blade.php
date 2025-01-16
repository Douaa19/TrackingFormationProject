@php
    $payload = $ticket->envato_payload;
    $supported_until = null;
    $expiredDate = null;
    $supportDuration = null;
    $supportDurationCount = null;

    if ($payload?->supported_until) {
        $supported_until = \Carbon\Carbon::parse($payload->supported_until);
        $expiredDate = $supported_until->format('l, F j, Y \a\t g:i A');
        $now = \Carbon\Carbon::now();
        $supportDurationCount = $now->diffInDays($supported_until, false);
        if ($supportDurationCount < 0) {
            $supportDuration = translate("Support Expired: ") . abs($supportDurationCount) . translate(' days ago');
        } else {
            $supportDuration = translate("Support Duration: ") . $supportDurationCount . ' days remaining';
        }
    }
@endphp

<div class="row g-3 align-items-center">
    <div class="col-md-auto">
        <img src="{{getImageUrl(getFilePaths()['profile']['user']['path'] . "/" . @$ticket->user->image) }}"
            alt="{{@$ticket->user->image}}" class="avatar-md rounded-circle" />
    </div>
    <div class="col-md">
        <div class="hstack gap-3 flex-wrap mb-2">
            <h4 class="fw-semibold" id="ticket-title"> {{$ticket->user->name}} {{limit_words($ticket->subject, 25)}}
            </h4>
            @if(site_settings(key: 'envato_verification', default: 0) == 1)
                @if($payload)

                    <div class="vr"></div>
                    <span class="fs-12 badge badge-soft-success rounded-pill">
                        {{ translate("Envato Verified") }}
                    </span>

                    @if(site_settings(key: 'envato_support_verification', default: 0) == 1)
                        <div class="vr"></div>
                        @if($ticket->is_support_expired == 1 && $supportDurationCount < 0)
                            <span class="fs-12 badge badge-soft-danger rounded-pill" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-html="true" title="{{"<span class='fs-10 fw-medium'>" . $supportDuration . "</span>"}}"
                                target="_blank">
                                {{ translate("Support Expired") }}
                            </span>
                        @else
                            <span class="fs-12 badge badge-soft-success rounded-pill" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{$payload?->supported_until ? "$supportDuration" : translate("Support Duration: Lifetime")}}"
                                target="_blank">
                                {{ translate("Active Support") }}
                            </span>
                        @endif
                    @endif

                @endif
            @endif
        </div>

        <div class="hstack gap-3 flex-wrap">
            <div class="text-muted"><i class="ri-bug-line align-bottom me-1"></i><span id="ticket-client">
                    {{@get_translation($ticket->category->name) }}
                </span></div>
            <div class="vr"></div>
            <div class="text-muted">{{translate('Create Date')}} : <span class="fw-medium " id="create-date">
                    {{getDateTime($ticket->created_at)}}
                </span></div>
            <div class="vr"></div>
            @if($ticket->linkedPriority)
                @php echo priority_status(@$ticket->linkedPriority->name ,@$ticket->linkedPriority->color_code ,'12')
                @endphp
            @endif
        </div>
    </div>
</div>