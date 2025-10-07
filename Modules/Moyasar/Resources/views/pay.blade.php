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


    {{-- <form class="pay-form needs-validation"
        action="{{ route('gateway.complete', withOldQueryIntegrity(['gateway' => moduleConfig('moyasar.alias')])) }}" method="post"
        id="payment-form">
        @csrf
        <input type="hidden" name="payment_id">
    </form> --}}

@endsection


@section('js')
    <script>
        Moyasar.init({
        element: '.mysr-form',
        amount: {{ $price }},
        currency: '{{ $purchaseData->currency_code }}',
        description: 'Coffee Order #1',
        publishable_api_key: '{{ $publishableKey }}',
        callback_url: '{{ route('gateway.callback', withOldQueryIntegrity(['gateway' => moduleConfig('moyasar.alias')])) }}',
        supported_networks: ['visa', 'mastercard', 'mada'],
        methods: ['creditcard'],
        on_completed: async function (payment) {
            await savePaymentOnBackend(payment);
        },
        
        });

        async function savePaymentOnBackend(payment) {
       
            // document.getElementById('payment_id').value = payment.id;
            // document.getElementById('payment-form').submit();

            $.ajax({
                url: '{{ route('gateway.complete', withOldQueryIntegrity(['gateway' => moduleConfig('moyasar.alias')])) }}',
                type: 'POST',
                data: { 
                    payment_id: payment.id,
                    csrf_token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response);
                }
            });

        }
    </script>
@endsection
