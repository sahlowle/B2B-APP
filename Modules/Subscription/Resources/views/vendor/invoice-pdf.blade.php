<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ __('Invoice') }}</title>
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/bootstrap-v5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Subscription/Resources/assets/css/subscription-invoice.min.css') }}">
</head>
<body>
    <div id="invoice-view-container" class="mx-4 color-gray">
        <div>
            <div class="w-25 d-inline-block">
                <img class="w-100" src="{{ $logo }}">
            </div>
            <div class="float-end">
                <h1 class="text-uppercase color-gray">{{ __('Invoice') }}</h1>
            </div>
        </div>

        <div class="mt-4 border-bottom-2-ddd">
            <div class="w-50 d-inline-block pb-3">
                <p class="w-100 mt-5 pt-2 color-gray">{{ __('Thank you for using :x', ['x' => preference('company_name')]) }}</p>
            </div>
            <div class="float-end">
                <p class="mb-2 text-end color-gray"><span>{{ __('Invoice number') }}: {{ $subscription->id }}</span></p>
                <p class="mb-2 text-end color-gray"><span>{{ __('Invoice date') }}: {{ timezoneFormatDate($subscription->created_at) }}</span></p>
                <p class="mb-2 text-end color-gray"><span>{{ __('To be paid until') }}: {{ timezoneFormatDate($subscription->due_date) }}</span></p>
            </div>
        </div>

        <div class="border-bottom-2-ddd pb-3">
            <div class="w-50 d-inline-block ">
                <div class="w-75 d-inline-block mx-5 ">
                    <div class="ms-5">
                        <p class="w-100 fw-bold mt-3 pt-2">{{ __('Features') }}</p>

                        <div class="w-100">
                            @foreach ($subscriptionFeatures as $key => $feature)
                                @if (is_int($feature['limit']))
                                    <div class="mb-2">
                                        <span class="color-gray">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                        <span class="float-end color-gray">{{ $feature['used'] . '/'. ($feature['limit'] == -1 ? __('Unlimited') : $feature['limit'] + $feature['used']) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="float-start">
                <p class="w-100 fw-bold mt-3 pt-2">{{ __('Billed to') }}</p>
                <p class="mb-2 color-gray">{{ $subscription->user?->name ?? __('Unknown') }}</p>
                <p class="mb-2 color-gray">{{ $subscription->user?->email ?? __('Unknown') }}</p>
            </div>
            <div class="float-end">
                <p class="w-50 fw-bold mt-3 pt-2">{{ __('Subscription') }}</p>
                <div class="mb-2">
                    <span class="color-gray">{{ __('Code') }}:</span>
                    <span class="color-gray">{{ $subscription->code }}</span>
                </div>
                <div class="mb-2">
                    <span class="color-gray">{{ __('Plan') }}:</span>
                    <span class="float-end color-gray">{{ $subscription->package?->name ?? __('Unknown') }}</span>
                </div>
                
                <div class="mb-2">
                    <span class="color-gray">{{ __('Status') }}:</span>
                    <span class="float-end color-gray">{{ $subscription->status }}</span>
                </div>
                <div class="mb-2">
                    <span class="color-gray">{{ __('Payment') }}:</span>
                    <span class="float-end color-gray">{{ $subscription->payment_status }}</span>
                </div>
            </div>
        </div>

        <div class="border-bottom-1-ddd">
            <div class="w-50 d-inline-block">
                <p class="w-100 mt-5 pt-2 mb-1 fw-bold">{{ __('Description') }}</p>
            </div>
            <div class="float-end">
                <p class="w-100 mt-5 pt-2 mb-1 fw-bold">{{ __('Price') }}</p>
            </div>
        </div>

        <div class="border-bottom-1-ddd">
            <div class="w-75 d-inline-block">
                <p class="w-100 py-3 mb-1 color-gray">{{ __('Subscription fee for period (:x - :y)', ['x' => timezoneFormatDate($subscription->billing_date), 'y' => timezoneFormatDate($subscription->next_billing_date)]) }}</p>
            </div>
            <div class="float-end">
                <p class="w-100 pt-3">{{ formatNumber($subscription->amount_billed) }}</p>
            </div>
        </div>

        <div class="w-100">
            <div class="w-25 float-end mt-3" >
                <div class="float-start">
                    <p class="w-50 mb-6 text-end color-gray">{{ __('Discount') }}:</p>
                    <p class="w-50 mb-6 text-end color-gray">{{ __('Total') }}:</p>
                    <p class="w-50 mb-6 text-end color-gray">{{ __('Tax') }}:</p>
                    <p class="w-50 mb-6 text-end mt-1 color-gray">{{ __('Paid') }}:</p>
                    <p class="w-50 mb-6 text-end mt-1 color-gray">{{ __('Due') }}:</p>
                </div>
                <div class="float-end">
                    <p class="w-50 mb-6 ms-4 text-end">{{ formatNumber($subscription->discount) }}</p>
                    <p class="w-50 mb-6 ms-4 text-end">{{ formatNumber($subscription->amount_billed) }}</p>
                    <p class="w-50 mb-6 ms-4 text-end">{{ formatNumber($subscription->tax) }}</p>
                    <p class="w-50 mb-6 ms-4 text-end">{{ formatNumber($subscription->amount_received) }}</p>
                    <p class="w-50 mb-6 ms-4 text-end">{{ formatNumber($subscription->amount_billed - $subscription->amount_received) }}</p>
                </div>
            </div>
        </div>

        <div class="clear">
            <p class="keep-in-touch mb-3 fw-bold">{{ __('Keep in touch')}}</p>
            <p class="concern-queries mb-2">{{ __('If you have any queries, concerns or suggestions')}},</p>
            @if (preference('company_email'))
                <p class="concern-queries mt-0 mb-2">{{ __('Email us')}} : <span class="color-blue">{{ preference('company_email') }}</span> </p>
            @endif
            @if (preference('company_phone'))
                <p class="helpline mb-2">{{ __('Helpline')}} : <span class="color-blue">{{ preference('company_phone') }}</span></p>
            @endif
            <p class="copy-right mb-2"> © {{ date("Y") }}, {{ preference('company_name') }}. {{ __('All rights reserved.') }}</p>
        </div>
    </div>
</body>
</html>
