<div class="card-header">
    <h5 class="card-title text-uppercase"><span class="font-bold">#{{ $order->reference }}</span> {{__('Order Details')}}</h5>
    <div class="row">
        <div class="col-sm-12 col-md">
            <h6 class="card-subtitle text-muted">{{ __('Payment Status') }} :
                {!! statusBadges($order->payment_status) !!}
            </h6>
        </div>
        @if(optional($order->paymentMethod)->gateway != null)
        <div class="col-sm-12 col-md">
            <h6 class="card-subtitle text-muted">{{ __('Payment Method') }}: <span class="badge badge-mv-secondary f-12 f-w-600">{{ paymentRenamed(optional($order->paymentMethod)->gateway) }}</span></span></h6>
        </div>
        @endif
        @if($order->paid > 0 && !empty(optional($order->transaction)->transaction_date))
        <div class="col-sm-12 col-md">
            <h6 class="card-subtitle text-muted">{{ __('Paid On') }}: <span class="font-bold">{{ formatDate(optional($order->transaction)->transaction_date) }}</span> @if(!empty($order->TransactionId($order->id)))<a href="{{ route('transaction.edit', $order->TransactionId($order->id)) }}">({{ __('View Transaction') }})</a>@endif</h6>
        </div>
        @endif
    </div>
</div>
