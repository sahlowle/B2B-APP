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
                    
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6">
                        <h6>{{ __('Invoice') }}</h6>
                        <p>
                            <strong>{{ __('Invoice #:') }}</strong> {{ $invoice->invoice_number }}<br>
                            <strong>{{ __('Currency:') }}</strong> {{ $invoice->currency }}<br>
                            <strong>{{ __('Total:') }}</strong> {{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
