@extends('gateway::layouts.payment')

@section('logo', asset(moduleConfig('moyasar.logo')))

@section('gateway', moduleConfig('moyasar.name'))

@section('content')
    <p class="para-6">{{ __('Fill in the required information') }}</p>
    <div class="straight-line"></div>

    @include('gateway::partial.instruction')

    <form class="pay-form needs-validation"
        action="{{ route('gateway.complete', withOldQueryIntegrity(['gateway' => moduleConfig('moyasar.alias')])) }}" method="post"
        id="payment-form">
        @csrf

        <button type="submit" class="pay-button sub-btn">{{ __('Pay With Credit Card') }}</button>
    </form>
@endsection

@section('css')
@endsection

@section('js')
@endsection
