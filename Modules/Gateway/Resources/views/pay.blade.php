@extends('gateway::layouts.master')

@section('content')
    @php
        // $purchaseData get from controller
        $query = request()->query->all() ?? [];
        $paymentType = request()->paymentType ? request()->paymentType . 'PayableGateways' : 'payableGateways';
        
        $gateways = (new Modules\Gateway\Entities\GatewayModule())->$paymentType();
        
        if (empty($purchaseData)) {
            abort(404);
        }
        
        if ($purchaseData->status == 'completed') {
            $message = __('Already paid for the order.');
        }
    @endphp
    @forelse ($gateways as $gateway)
        <a href="{{ route('gateway.pay', withOldQueryIntegrity(['gateway' => $gateway->alias])) }}" class="pay-box">
            <div class="grow">
                <img class="image-2" src="{{ asset(moduleConfig($gateway->alias . '.logo')) }}" alt="{{ __('Image') }}" />
            </div>
        </a>
    @empty
        <a href="javascript:void(0)" onclick="history.back()" class="pay-box">
            <div class="grow">
                <h3>{{ __('No gateway found.') }}</h3>
            </div>
        </a>
    @endforelse
@endsection
