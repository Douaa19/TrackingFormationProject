<div class="modal fade zoomIn" id="bulkDeleteModal" tabindex="-1" aria-hidden="true">
	
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
							{{translate('Do You Want To Delete These Records??')}}
                        </p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light"
                        data-bs-dismiss="modal">
                        {{translate('Close')}}
                    
                    </button>
                    <button class="btn w-sm btn-danger  bulkActionBtn"
                        data-type ="delete" name="bulk_status" value="delete">
                        {{translate('Yes, Delete It!')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>