    <div id="confirmDelete" class="modal modal-blur fade" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger" style="width: 3.5rem;height: 3.5rem;" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
                <h3 class="fs-6 lh-1_5 fw-600">{{ __('Are you sure?') }}</h3>
                <div class="text-secondary text-muted">{{ __('Once performed, this action cannot be undone.') }}</div>
                
                <form action="#" id="internal_form" method="post">
                    @csrf
                    <input type="hidden" name="data" id="data">
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" id="confirmDeleteSubmitBtn" data-task="" class="btn btn-danger delete-section-btn">{{ __('Yes, Confirm') }}</button>
                <span class="ajax-loading"></span>
            </div>
        </div>
    </div>
</div>

