@extends('admin.layouts.app')
@section('page_title', __('Invoices'))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Invoices') }}</h5>
                <div class="card-header-right">
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{ __('Create Invoice') }}
                    </a>
                </div>
            </div>
            <div class="card-block">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Invoice #') }}</th>
                                <th>{{ __('Currency') }}</th>
                                <th>{{ __('Total') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->currency }}</td>
                                    <td>{{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-info mx-1   btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning mx-1 btn-sm"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger mx-1 btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                       
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">{{ __('No invoices found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
