<div class="modal fade" id="edit-ticket-field" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modalTitle">{{ translate('Update Input Field') }}
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="d-flex flex-column gap-4 settingsForm " data-route="{{ route('admin.setting.ticket.input.update') }}"
                method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">

                    <div class="d-none" id="modalLoader">
                        <div class="spinner-border text-primary avatar-sm" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>

                    <div id="modalContent">


                    </div>

                    <div class="modal-footer px-0 pb-0 pt-3">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-danger waves ripple-light" data-bs-dismiss="modal">
                                {{ translate('Close
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ') }}
                            </button>
                            <button type="submit" class="btn btn-success waves ripple-light">
                                {{ translate('Submit') }}
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
