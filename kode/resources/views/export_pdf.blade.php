<!doctype html>
<html lang="{{app()->getLocale()}}" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>{{translate(@$title)}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ getImageUrl(getFilePaths()['site_logo']['path'] ."/".site_settings('site_favicon')) }}" >
    <link href="{{asset('assets/global/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/root.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/backend/css/custom.css')}}" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="auth-page-content">
        <div class="card">
			<div class="card-body">
                <div class="table-responsive table-card pb-2">
                    <table
                        class="table table-border table-centered align-middle table-nowrap mb-0">
                        <thead class="text-muted table-light">
                        <tr>
                            <th scope="col">
                                {{translate("Ticket Id")}}
                            </th>
                            <th scope="col">
                                {{translate('Name')}}
                            </th>
                            <th scope="col">
                                {{translate("Email")}}
                            </th>
                            <th scope="col">
                                {{translate("Subject")}}
                            </th>
                            <th scope="col">
                                {{translate('Status')}}
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                            @forelse($ticket_data->chunk(5) as $chunksData)
                                @foreach($chunksData as $ticket)
                                        <tr>
                                            <td>
                                                <a href="javascript:void(0)"
                                                    class="fw-medium link-primary">
                                                    {{$ticket->ticket_number}}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">

                                                    <div class="flex-grow-1">
                                                        {{limit_words($ticket->name,10)}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{$ticket->email}}
                                            </td>
                                            <td>
                                                {{limit_words($ticket->subject,15)}}
                                            </td>

                                            <td>
                                                @php echo ticket_status($ticket->ticketStatus->name,$ticket->ticketStatus->color_code) @endphp 

                                            </td>

                                        </tr>

                                @endforeach
                            @empty
                               @include('admin.partials.not_found')
                            @endforelse
                        </tbody>
                    </table>
                </div>

			</div>
		</div>
    </div>
</body>
</html>
