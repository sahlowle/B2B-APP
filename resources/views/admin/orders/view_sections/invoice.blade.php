<div class="card">
    <div class="card-header">
        <h5>{{ __('Create PDF') }}</h5>
        <div class="card-header-right">
            <div class="btn-group card-option card-accordion">
                <button type="button" class="btn dropdown-toggle drop-down-icon text-mute">
                    <i class="fas fa-angle-down"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="order-pdf-btn sections-body accordion-body">
        <a href="{{ route('invoice.print', ['id' => $order->id, 'type' => 'print' ]) }}" {{ json_decode(preference('invoice'))?->general->pdf_view == 'new_tap' ? 'target="_blank"' : '' }} ><button class="pdf-inv-btn">{{ __('PDF Invoice') }}</button></a>
    </div>
</div>
