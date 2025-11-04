@extends('admin.layouts.app')
@section('page_title', __('Quotation Details'))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>
                    <a href="{{ route('quotation.index') }}">{{ __('Quotations') }}</a>
                    > {{ __('Quotation') }} #{{ $quotation->id }}
                </h5>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6">
                        <h6>{{ __('Customer Information') }}</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">{{ __('First Name:') }}</th>
                                <td>{{ $quotation->first_name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Last Name:') }}</th>
                                <td>{{ $quotation->last_name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Email:') }}</th>
                                <td>{{ $quotation->email }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Phone Number:') }}</th>
                                <td>{{ $quotation->phone_number }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Country:') }}</th>
                                <td>
                                        {{ $quotation->country->name }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6>{{ __('Quotation Information') }}</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">{{ __('Quotation ID:') }}</th>
                                <td>#{{ $quotation->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Category:') }}</th>
                                <td>
                                    
                                    {{ $quotation->category->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Status:') }}</th>
                                <td>
                                    <span class="badge badge-{{ $quotation->status == 'pending' ? 'warning' : ($quotation->status == 'approved' ? 'success' : 'danger') }}">
                                        {{ ucfirst($quotation->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Created At:') }}</th>
                                <td>{{ $quotation->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Updated At:') }}</th>
                                <td>{{ $quotation->updated_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($quotation->notes)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h6>{{ __('Notes') }}</h6>
                        <div class="card">
                            <div class="card-body">
                                <p>{{ $quotation->notes }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($quotation->pdf_file)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h6>{{ __('PDF File') }}</h6>
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ $quotation->pdf_file }}" target="_blank" class="btn btn-primary">
                                    <i class="fa fa-file-pdf"></i> {{ __('View PDF') }}
                                </a>
                                <a href="{{ $quotation->pdf_file }}" download class="btn btn-success">
                                    <i class="fa fa-download"></i> {{ __('Download PDF') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

