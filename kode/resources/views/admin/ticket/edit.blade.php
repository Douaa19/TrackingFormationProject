@extends('admin.layouts.master')

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
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">
                                {{translate('Home')}}
                            </a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.ticket.list')}}">
                                {{translate('Tickets')}}
                            </a></li>
                        <li class="breadcrumb-item active">
                            {{translate('Edit')}}
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
                            {{translate('Edit Ticket')}}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <form action="{{route('admin.ticket.update',$ticket->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4 pb-3">

                    <div class="col-md-12">

                        <label for="department_id" class="form-label">
                            {{translate("Product")}} 
                            <span class="text-danger">*</span>
                        </label>

                        <select class="form-select" id="department_id" name="department_id" required>
                            <option value="">
                                {{translate("Select product")}}
                            </option>


                            @foreach($departments as $department)

                                <option {{$department->id == $ticket->department_id ? "selected" :""}} value="{{ $department->id }}">
                                    {{($department->name) }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-12">

                        <label for="category_id" class="form-label">
                            {{translate("Ticket category")}}
                            <span class="text-danger">*</span>
                        </label>

                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">
                                {{translate("Select category")}}
                            </option>


                            @foreach($categories as $category)

                                <option {{$category->id == $ticket->category_id ? "selected" :""}} value="{{ $category->id }}">
                                    {{ get_translation($category->name) }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-12">

                        <label for="priority_id" class="form-label">
                            {{translate("Ticket priority")}}
                            <span class="text-danger">*</span>
                        </label>

                        <select class="form-select" id="priority_id" name="priority_id" required>
                            <option value="">
                                {{translate("Select priority")}}
                            </option>


                            @foreach($priorities as $priority)

                                <option {{$priority->id == $ticket->linkedPriority->id ? "selected" :""}} value="{{ $priority->id }}">
                                    {{($priority->name) }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-12">

                        <label for="status_id" class="form-label" >
                            {{translate("Ticket status")}}
                            <span class="text-danger">*</span>
                        </label>

                        <select class="form-select" id="status_id" name="status" required>
                            <option value="">
                                {{translate("Select status")}}
                            </option>


                            @foreach($ticketStatuses as $status)

                                <option {{$status->id == $ticket->ticketStatus->id ? "selected" :""}} value="{{ $status->id }}">
                                    {{ ($status->name) }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-12">

                        <label for="subject" class="form-label">
                            {{translate("subject")}}
                            <span class="text-danger">*</span>
                        </label>

                        <input type="text" class="form-control" id="subject" name="subject" placeholder="{{translate('subject')}}" value="{{$ticket->subject}}" required>

                    </div>

            
                    <div class="col-12">
                        <div class="text-start">
                            <button type="submit" class="btn btn-success">
                                {{translate('Update')}}
                            </button>

                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection





