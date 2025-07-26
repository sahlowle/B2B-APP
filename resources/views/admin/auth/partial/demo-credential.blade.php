@if(config('martvill.is_demo'))
<div id="admin-login-container" class="admin-login-container">
    <div class="d-flex justify-content-center align-items-center mb-3">
        <hr class="border border-gray-2 w-full">

        <p class="px-3 md:px-5 sign-in-demo-admin m-0">{{ __('Demo Login') }}</p>

        <hr class="border border-gray-2 w-full">
    </div>
    <div class="d-flex justify-content-center align-items-center mb-3">
        <button type="submit" data-type="admin" class="btn btn-secondary one-click-login mx-3">{{ __('ADMIN') }}</button>
        <button type="submit" data-type="vendor" class="btn btn-secondary one-click-login mx-3">{{ __('VENDOR') }}</button>
    </div>
</div>
@endif
