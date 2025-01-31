<div class="modal fade zoomIn delete_modal" id="delete-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header  delete-modal-header">
               
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="{{asset('assets/global/json/gsqxdxog.json')}}" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548"
                        class="loader-icon"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>
                           {{translate('Are you sure ?')}}
                        </h4>
                        <p class="text-muted mx-4 mb-0">
                            {{translate('Are you sure you want to
                            remove this record ?')}}
                        </p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light close-delete-modal"
                        data-bs-dismiss="modal">
                        {{translate('Close')}}
                    
                    </button>
                    <a href="" class="btn w-sm btn-danger "
                        id="delete-href">
                        {{translate('Yes, Delete It!')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>