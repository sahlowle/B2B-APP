@extends('gateway::layouts.payment')

@section('logo', asset(moduleConfig('moyasar.logo')))

@section('gateway', moduleConfig('moyasar.name'))

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/moyasar-payment-form@2.1.1/dist/moyasar.css" />
    <script src="https://cdn.jsdelivr.net/npm/moyasar-payment-form@2.1.1/dist/moyasar.umd.min.js"></script>
@endsection

@section('content')
    <p class="para-6">{{ __('Fill in the required information') }}</p>
    <div class="straight-line"></div>

    {{-- @include('gateway::partial.instruction') --}}

    <div class="mysr-form"></div>


    <form class="pay-form needs-validation"
        action="{{ route('gateway.complete', withOldQueryIntegrity(['gateway' => moduleConfig('moyasar.alias')])) }}" method="post"
        id="payment-form">
        @csrf
        <input type="hidden" name="payment_id">
    </form>

@endsection


@section('js')
    <script>
        Moyasar.init({
        element: '.mysr-form',
        // Amount in the smallest currency unit.
        // For example:
        // 10 SAR = 10 * 100 Halalas
        // 10 KWD = 10 * 1000 Fils
        // 10 JPY = 10 JPY (Japanese Yen does not have fractions)
        amount: {{ $price }},
        currency: '{{ $purchaseData->currency_code }}',
        description: 'Coffee Order #1',
        publishable_api_key: 'pk_test_wV6yFUYWypyw3fc32N7kknbMfAEHUYEQrryhYW2J',
        callback_url: '{{ route('gateway.callback', withOldQueryIntegrity(['gateway' => moduleConfig('moyasar.alias')])) }}',
        supported_networks: ['visa', 'mastercard', 'mada'],
        methods: ['creditcard'],
        on_completed: async function (payment) {
            await savePaymentOnBackend(payment);
        },
        
        });

        async function savePaymentOnBackend(payment) {
            console.log(payment);
            alert(payment.id);
            document.getElementById('payment_id').value = payment.id;
            document.getElementById('payment-form').submit();
        }
    </script>
@endsection
