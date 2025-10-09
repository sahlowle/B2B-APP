@extends('admin.layouts.app')
@section('page_title', __('Subscription Invoice'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Subscription/Resources/assets/css/subscription.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="invoice-container">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h5>{{ __('Invoice') }}</h5>
            </div>
        </div>
    </div>
    <div class="col-sm-12" id="sales-invoice-view-details-container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <div class="btn-{{ $subscription->status == 'Active' ? 'paid' : 'unpaid' }}">{{ $subscription->status }}</div>

                            @if ($subscription->payment_status == 'Paid')
                                <div class="btn-paid">{{ __('Paid') }}</div>
                            @else
                                <div class="btn-unpaid">{{ __('Unpaid') }}</div>

                                <form class="float-right" action="{{ route('payment.paid', $subscription->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm mt-2 ml-1 btn-primary">{{ __('Pay Now') }}</button>
                                </form>
                            @endif
                        </div>
                        <div class="btn-group float-end  me-2 mt-1 ps-3" role="group" aria-label="Basic example">
                            <button title="{{ __('Email') }}" id="email_invoice" type="button"
                                url="{{ route('package.subscription.invoice.email', ['id' => $subscription->id]) }}"
                                class="btn custom-btn-small btn-outline-secondary border-end-0">{{ __('Email') }} <i class="feather"></i></button>
                            <a target="_blank" href="{{ route('package.subscription.invoice.pdf', ['id' => $subscription->id]) }}"
                                title="{{ __("PDF") }}" class="btn custom-btn-small btn-outline-secondary">{{ __('PDF') }}</a>
                          </div>
                    </div>
                    <div class="card-body">
                        <div class="m-t-10">
                            <div class="row m-t-10 ml-2">
                                <div class="col-md-4 m-b-15">
                                    <div><strong class="company-name">{{ preference('company_name') }}</strong></div>
                                    <div class="d-block">
                                        <span class="company-info">{{ preference('company_street') }}, {{ preference('company_city') }}</span>
                                        <span class="company-info">{{ preference('company_zipCode') }}</span>
                                    </div>
                                    <span class="company-info">
                                        {{ __('Web') }}: <a class="company-info-url" href="{{ url('/') }}">{{ url('/') }}</a>
                                    </span>
                                </div>
                                <div class="col-md-4 m-b-15">
                                    <strong class="text-black">{{ __('Bill To') }}</strong><br>
                                    <strong class="text-black">{{ $subscription?->user?->name }}</strong><br>
                                    <strong>{{ $subscription?->user?->address }}</strong><br>
                                </div>
                                <div class="col-md-4 m-b-15">
                                    <strong class="d-block">{{ __('Code') }}: {{ $subscription->code }}</strong>
                                    <strong class="d-block">{{ __('Billing Date') }}: {{ timezoneFormatDate($subscription->billing_date) }}</strong>
                                    @if ($subscription->billing_cycle)
                                        <strong class="d-block">{{ __('Next Billing Date') }}: {{ ($subscription->billing_cycle == 'lifetime' && $subscription->is_trial == 0) ? __('Not Applicable') : timezoneFormatDate($subscription->next_billing_date) }}</strong>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-0">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="salesInvoice">
                                            <thead>
                                                <tr class="tbl_header_color dynamicRows">
                                                    <th>{{ __('Plan') }}</th>
                                                    <th width="10%" class="text-center">{{ __('Billing Cycle') }}</th>
                                                    <th width="8%" class="text-center">{{ __("Renewable") }}</th>
                                                    <th width="10%" class="text-center">{{ __('Tax') }} (%)</th>
                                                    <th width="10%" class="text-center">
                                                        {{ __('Total') }} ({{ \App\Models\Currency::getAll()->where('id', preference('dflt_currency_id'))->first()->symbol }})
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="white-space-unset">
                                                        <span class="break-all f-16">
                                                            {{ $subscription?->package?->name ?? __('Unknown') }}
                                                        </span> <br>
                                                    </td>
                                                    <td width="5%" class="white-space-unset text-center">{{ ucfirst($subscription->billing_cycle) }}</td>
                                                    <td width="8%" class="white-space-unset text-center">{{ $subscription->renewable ? __('Yes') : __('No') }}</td>
                                                    <td width="10%" class="white-space-unset text-center">0</td>
                                                    <td class="white-space-unset text-center">{{ formatCurrencyAmount($subscription->amount_billed) }}</td>
                                                </tr>
                                                <tr class="tableInfos">
                                                    <td colspan="4" align="right">{{ __('Sub Total') }}</td>
                                                    <td class="text-center" colspan="1">{{ formatCurrencyAmount($subscription->amount_billed) }}</td>
                                                </tr>

                                                <tr class="tableInfos">
                                                    <td colspan="4" align="right">
                                                        {{ __('Other discount') }}
                                                    </td>
                                                    <td class="text-center">0.00</td>
                                                </tr>

                                                <tr class="tableInfos">
                                                    <td colspan="4" align="right">
                                                        <strong>{{ __('Grand Total') }}</strong>
                                                    </td>
                                                    <td colspan="1" class="text-center">
                                                        <strong>{{ formatCurrencyAmount($subscription->amount_billed) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr class="tableInfos">
                                                    <td colspan="4" align="right">{{ __('Paid') }}</td>
                                                    <td colspan="1" class="text-center">
                                                        {{ formatCurrencyAmount($subscription->amount_received) }}
                                                    </td>
                                                </tr>
                                                <tr class="tableInfos">
                                                    <td colspan="4" align="right">
                                                        <strong>{{ __('Due') }}</strong>
                                                    </td>

                                                    <td colspan="1" class="text-center">
                                                        <strong>
                                                            {{ formatCurrencyAmount($subscription->amount_billed - $subscription->amount_received) }}
                                                        </strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('Modules/Subscription/Resources/assets/js/subscription.min.js') }}"></script>
@endsection
