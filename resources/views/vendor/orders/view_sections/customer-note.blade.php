@if (!empty($order->note))
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Customer Note') }}</h5>
            <div class="card-header-right">
                <div class="btn-group card-option card-accordion">
                    <button type="button" class="btn dropdown-toggle drop-down-icon text-mute">
                        <i class="fas fa-angle-down"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="order-pdf-btn sections-body accordion-body">
            <p>{{ $order->note }}</p>
        </div>
    </div>
@endif
