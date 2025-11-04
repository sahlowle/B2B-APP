@extends('admin.layouts.app')
@section('page_title', __('Quotations'))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Quotations') }}</h5>
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

                <!-- Filters -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6>{{ __('Filters') }}</h6>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('quotation.index') }}" id="filter-form">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="search">{{ __('Search') }}</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="search" 
                                               name="search" 
                                               value="{{ request('search') }}" 
                                               placeholder="{{ __('Search by name, email, phone...') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="category_id">{{ __('Category') }}</label>
                                        <select class="form-control" id="category_id" name="category_id">
                                            <option value="">{{ __('All Categories') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status">{{ __('Status') }}</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="">{{ __('All Status') }}</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="date_from">{{ __('Date From') }}</label>
                                        <input type="date" 
                                               class="form-control" 
                                               id="date_from" 
                                               name="date_from" 
                                               value="{{ request('date_from') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="date_to">{{ __('Date To') }}</label>
                                        <input type="date" 
                                               class="form-control" 
                                               id="date_to" 
                                               name="date_to" 
                                               value="{{ request('date_to') }}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="fa fa-filter"></i> {{ __('Filter') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(request()->hasAny(['search', 'category_id', 'status', 'date_from', 'date_to']))
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('quotation.index') }}" class="btn btn-sm btn-secondary">
                                        <i class="fa fa-times"></i> {{ __('Clear Filters') }}
                                    </a>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($quotations as $quotation)
                                <tr>
                                    <td>#{{ $quotation->id }}</td>
                                    <td>{{ $quotation->first_name }} {{ $quotation->last_name }}</td>
                                    <td>{{ $quotation->email }}</td>
                                    <td>{{ $quotation->phone_number }}</td>
                                    <td>{{ $quotation->category->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $quotation->status == 'pending' ? 'warning' : ($quotation->status == 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($quotation->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $quotation->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('quotation.show', $quotation) }}" class="btn btn-info mx-1 btn-sm">
                                                <i class="fa fa-eye"></i> {{ __('View') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('No quotations found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $quotations->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

