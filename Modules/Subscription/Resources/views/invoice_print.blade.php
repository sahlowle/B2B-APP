<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ __('Invoice') }}</title>
    <link rel="stylesheet" href="{{ asset('public/dist/css/pdf-invoice.min.css') }}">
</head>
<body>
    <div id="invoice-view-container">
        <div id="printTable">
            <div>
                <div class="invoice-side">
                    <img class="martvill-logo" src="{{ $logo }}" alt="{{ __('Image') }}">
                </div>
                <div class="address-side">
                    <div>
                        <p class="name">{{ preference('company_name') }}</p>
                    </div>
                    <div >
                        <p class="phone-email">{{ preference('company_street') }}, {{ preference('company_city') }}</p>
                        <p class="phone-email">{{ preference('company_zipCode') }}</p>
                    </div>
                    <p class="phone-email">
                        {{ __('Web') }}: <a class="company-info-url" href="{{ url('/') }}">{{ url('/') }}</a>
                    </p>
                </div>
                <div class="clear-both"></div>
            </div>
            <div class="border-1">
                <p class="invoice">{{ __('invoice')}}</p>
                <p  class="code">{{ __('Code') }}: {{ $subscription->code }}</p>
            </div>
            <div class="mt-36px">
                <div class="invoice-side">
                    <p class="billed-to">{{ __('Billed To') }}</p>
                    <p class="sub-user-name">{{ $subscription?->user?->name }}</p>
                    @if (isset($subscription->user) && !empty($subscription->user->phone))
                        <p class="sub-user-phn">{{ $subscription->user->phone }}</p>
                    @endif
                    @if (isset($subscription->user) && !empty($subscription->user->email))
                        <p class="sub-user-email">{{ $subscription->user->email }}</p>
                    @endif
                    <p class="sub-user-add">{{ $subscription?->user?->address }}</p>
                    <p class="status">{{ __(ucfirst($subscription->payment_status)) }}</p>
                </div>
                <div class="address-side">
                    <p class="subscription">{{ __('SUBSCRIPTION')}}</p>
                    <p class="btn-{{ $subscription->status == 'Active' ? 'paid' : 'unpaid' }} active-status">Status:{{ $subscription->status }}
                    </p>
                    <p class="bill-date">{{ __('Billing Date') }}: {{ timezoneFormatDate($subscription->billing_date) }}</p>
                    <p class="bill-date">{{ __('Next Billing Date') }}: {{ $subscription->billing_cycle == 'lifetime' ? __('Not Applicable') : timezoneFormatDate($subscription->next_billing_date) }}</p>
                </div>
                <div class="clear-both"></div>
            </div>
        </div>
        <div class="mt-28px">
            <table class="table">
                <thead class="thead text-left">
                    <tr>
                        <th class="width-280 text-left">{{ __('Plan') }}</th>
                        <th class="text-left width-280">{{ __('Billing Cycle') }}</th>
                        <th class="text-left">{{ __('Renewable') }}</th>
                        <th class="whitespace-nowrap text-right"> {{ __('Total') }} ({{ \App\Models\Currency::getAll()->where('id', preference('dflt_currency_id'))->first()->symbol }})</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="td width-280 text-left">
                            {{ $subscription?->package?->name ?? __('Unknown') }}
                        </td>
                        <td class="text-left td width-280">
                            <p> {{ ucfirst($subscription->billing_cycle) }} </p>
                        </td>
                        <td class="td text-left">
                            <p>{{ $subscription->renewable ? __('Yes') : __('No') }}</p>
                        </td>
                        <td class="td text-right">
                            <p>{{ formatCurrencyAmount($subscription->billing_price) }}</p>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="footer-text color-89">{{ __('Discount') }}</td>
                        <td class="footer-text color-89 text-right">{{ formatCurrencyAmount($subscription->billing_price - $subscription->amount_billed) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="footer-text color-14">{{ __('Grand Total') }}</td>
                        <td class="footer-text color-14 text-right">{{ formatCurrencyAmount($subscription->amount_billed) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="footer-text color-89">{{ __('Paid') }}</td>
                        <td class="footer-text color-89 text-right">{{ formatCurrencyAmount($subscription->amount_received) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="footer-text color-89">{{ __('Due') }}</td>
                        <td class="footer-text color-89 text-right">{{ formatCurrencyAmount($subscription->amount_billed - $subscription->amount_received) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div>
            <p class="keep-in-touch">{{ __('Keep in touch')}}</p>
            <p class="concern-queries">{{ __('If you have any queries, concerns or suggestions')}},</p>
            @if (preference('company_email'))
                <p class="concern-queries mt-0">{{ __('please email us')}} : <span class="email">{{ preference('company_email') }}</span></p>
            @endif
            @if (preference('company_phone'))
                <p class="helpline">{{ __('Helpline')}} </p>
                <p class="phone-number">{{ preference('company_phone') }}</p>
            @endif
            <p class="copy-right"> © {{ date("Y") }}, {{ preference('company_name') }}. {{ __('All rights reserved.') }}</p>
        </div>
    </div>
</body>
</html>
