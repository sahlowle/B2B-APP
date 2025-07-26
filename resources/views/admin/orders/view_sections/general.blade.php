<div class="card-header">
    <h5 class="card-title text-uppercase"><span class="font-bold">#{{ $order->reference }}</span> {{__('Order Details')}}</h5>
    <div class="row">
        <div class="col-sm-12 col-md">
            <div class="row">
                <div class="{{ $order->isPayable() ? 'col-sm-4' : 'col-sm-12' }}">
                    <h6 class="card-subtitle text-muted">{{ __('Payment Status') }} :
                        {!! statusBadges($order->payment_status) !!}
                    </h6>
                </div>
                @if($order->isPayable())
                <div class="col-sm-6">
                    <a href="javascript:void(0)" data-route="{{ route('site.order.custom.payment', ['reference' => techEncrypt($order->reference)]) }}" id="payment-link"> <h6 class="card-subtitle text-muted"><span class="badge badge-mv-primary f-12 f-w-600">{{ __('Copy Payment Link') }}</span></h6></a>
                </div>
                @endif
            </div>
        </div>
        
        @if(optional($order->paymentMethod)->gateway != null)
        <div class="col-sm-12 col-md">
            <h6 class="card-subtitle text-muted">{{ __('Payment Method') }}: <span class="badge badge-mv-secondary f-12 f-w-600">{{ paymentRenamed(optional($order->paymentMethod)->gateway) }}</span></h6>
        </div>
        @endif
        @if($order->paid > 0 && !empty(optional($order->transaction)->transaction_date))
        <div class="col-sm-12 col-md">
            <h6 class="card-subtitle text-muted">{{ __('Paid On') }}: <span class="font-bold">{{ formatDate(optional($order->transaction)->transaction_date) }}</span> @if(!empty($order->TransactionId($order->id)))<a href="{{ route('transaction.edit', $order->TransactionId($order->id)) }}">({{ __('View Transaction') }})</a>@endif</h6>
        </div>
        @endif
        
    </div>
</div>
