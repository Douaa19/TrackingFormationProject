<div class="modal fade" id="add-ticket-field" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modalTitle">{{ translate('Add More Input Field') }}
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ticketAddform" class="d-flex flex-column gap-4 settingsForm "
                data-route="{{ route('admin.setting.ticket.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-xl-12">
                            <div class="row">

                                <div class="col-lg-12 ">
                                    <div class="mb-3">
                                        <label class="form-label" for="labels">
                                            {{ translate('Label') }}
                                            <span class="text-danger"> *</span>
                                        </label>

                                        <input type="text" id="labels" name="labels"
                                            class="form-control" placeholder="{{ translate("Set a Label") }}">

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="type">
                                            {{ translate('Type') }}
                                            <span class="text-danger"> *</span>

                                        </label>

                                        <select class="form-select" id="type" name="type">
                                            <option value="" selected>
                                                 {{translate('Select Type')}}
                                            </option>

                                            @foreach ($inputTypes as  $type)
                                                <option value="{{ $type}}">
                                                    {{ k2t($type)}}
                                                </option>
                                            @endforeach

                                        </select>

                                        <div  class="d-none option-field">

                                        </div>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="width">
                                            {{ translate('Width') }}

                                            <span class="text-danger"> *</span>

                                        </label>

                                        <select class="form-select" id="width" name="width">
                                            @foreach($widths as $key => $value)
                                                <option {{Arr::get(@$ticketInput,'width',App\Enums\FieldWidth::COL_12->value) == $key ?'selected' :""}} value="{{$key}}">
                                                    {{ucfirst($value)}}%
                                                </option>  
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="mandatory_required">
                                            {{ translate('Mandatory/Required') }}
                                            <span class="text-danger"> *</span>
                                        </label>

                                        <select class="form-select" id="mandatory_required"
                                            name="required">
                                            <option value="{{App\Enums\StatusEnum::true->status()}}">

                                                 {{translate("Yes")}}
                                            </option>
                                            <option value="{{App\Enums\StatusEnum::false->status()}}">
                                                 {{translate("No")}}
                                            </option>
                                        </select>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="visibility">
                                            {{ translate('Visibility') }}
                                            <span class="text-danger"> *</span>
                                        </label>

                                        <select class="form-select" id="visibility" name="visibility">
                                            <option value="{{App\Enums\StatusEnum::true->status()}}">
                                                 {{translate('Visible')}}
                                            </option>
                                            <option value="{{App\Enums\StatusEnum::false->status()}}">
                                                 {{translate('Hidden')}}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3" id="hiddenFields">
                                        <label class="form-label" for="placeholder">
                                            {{ translate('Placeholder') }}
                                            <span class="text-danger"> *</span>
                                        </label>

                                        <input type="text" name="placeholder" id="placeholder" class="form-control"
                                            placeholder="{{translate('Set a placeholder for this new input field')}}">
                                         <input type="hidden" name="default" class="form-control"
                                            value="{{  App\Enums\StatusEnum::false->status() }}">

                  
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer px-0 pb-0 pt-3">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-danger waves ripple-light" data-bs-dismiss="modal">
                                {{ translate('Close
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ') }}
                            </button>
                            <button type="submit" class="btn btn-success waves ripple-light" id="add-btn">
                                {{ translate('Submit') }}
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>