@extends('admin.layouts.app')
@section('page_title', __('Invoice Details'))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>
                    <a href="{{ route('invoices.index') }}">{{ __('Invoices') }}</a>
                    > {{ __('Invoice') }} #{{ $invoice->invoice_number }}
                </h5>
                <div class="card-header-right">
                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> {{ __('Edit') }}
                    </a>
                    <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-success">
                        <i class="fa fa-file-pdf"></i> {{ __('Download PDF') }}
                    </a>
                    <a href="{{ route('invoices.print', $invoice) }}" class="btn btn-info" target="_blank">
                        <i class="fa fa-print"></i> {{ __('Print') }}
                    </a>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6">
                        <h6>{{ __('Customer Information') }}</h6>
                        <p>
                            <strong>{{ $invoice->customer_name }}</strong><br>
                            {{ $invoice->customer_email }}<br>
                            @if($invoice->customer_phone)
                                {{ $invoice->customer_phone }}<br>
                            @endif
                            @if($invoice->customer_address)
                                {{ $invoice->customer_address }}
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>{{ __('Invoice Details') }}</h6>
                        <p>
                            <strong>{{ __('Invoice #:') }}</strong> {{ $invoice->invoice_number }}<br>
                            <strong>{{ __('Date:') }}</strong> {{ $invoice->invoice_date->format('M d, Y') }}<br>
                            <strong>{{ __('Due Date:') }}</strong> {{ $invoice->due_date->format('M d, Y') }}<br>
                            <strong>{{ __('Status:') }}</strong> 
                            <span class="badge badge-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : 'warning') }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($invoice->billing_address)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>{{ __('Billing Address') }}</h6>
                            <p>{{ $invoice->billing_address }}</p>
                        </div>
                    </div>
                @endif

                <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th>{{ __('Unit Price') }}</th>
                                <th>{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->items as $item)
                                <tr>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $invoice->currency }} {{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ $invoice->currency }} {{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>{{ __('Subtotal:') }}</strong></td>
                                <td><strong>{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</strong></td>
                            </tr>
                            @if($invoice->tax_amount > 0)
                                <tr>
                                    <td colspan="3" class="text-right"><strong>{{ __('Tax (') }}{{ $invoice->tax_rate }}%):</strong></td>
                                    <td><strong>{{ $invoice->currency }} {{ number_format($invoice->tax_amount, 2) }}</strong></td>
                                </tr>
                            @endif
                            @if($invoice->discount_amount > 0)
                                <tr>
                                    <td colspan="3" class="text-right"><strong>{{ __('Discount:') }}</strong></td>
                                    <td><strong>-{{ $invoice->currency }} {{ number_format($invoice->discount_amount, 2) }}</strong></td>
                                </tr>
                            @endif
                            <tr class="table-active">
                                <td colspan="3" class="text-right"><strong>{{ __('Total:') }}</strong></td>
                                <td><strong>{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($invoice->notes)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>{{ __('Notes') }}</h6>
                            <p>{{ $invoice->notes }}</p>
                        </div>
                    </div>
                @endif

                @if($invoice->terms_conditions)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h6>{{ __('Terms & Conditions') }}</h6>
                            <p>{{ $invoice->terms_conditions }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
