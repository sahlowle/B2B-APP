<div class="card">
    <div class="card-header">
        <h5>{{ __('Order') }} {{ __('Actions') }}</h5>
        <div class="card-header-right">
            <div class="btn-group card-option card-accordion">
                <button type="button" class="btn dropdown-toggle drop-down-icon text-mute">
                    <i class="fas fa-angle-down"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="order-sections-body sections-body accordion-body">
        @if(request()->action != 'new')
        <div class="d-flex order-action-parent">
            <select class="form-control select2" name="order_action" id="orderAction">
                <option value="" selected="">{{ __('Choose an action..') }}</option>
                <option value="1">{{ __('Email invoice / order details to customer') }}</option>
                <option value="3">{{ __('Resend Order Email (Vendor)') }}</option>
            </select>
            <div class="order-mail">
                <span id="order_action_btn">
                    <i class="feather icon-chevron-right fa-2x"></i>
                </span>
            </div>
        </div>
        @endif
        <div class="trash-update border-top">
            <button class="w-100" id="update-order" class="mt-9">{{ __('Update') }}</button>
        </div>
    </div>
</div>
