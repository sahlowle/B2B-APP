@extends('admin.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Invoice')]))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5> 
                    <a href="{{ route('invoices.index') }}"> 
                        {{ __('Invoices') }} 
                    </a>
                    >
                    {{ __('Create :x', ['x' => __('Invoice')]) }}
                </h5>
            </div>
            <div class="card-block">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('invoices.store') }}" method="post" id="invoiceForm" class="form-horizontal">
                    @csrf
                    
                    <!-- Customer Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>{{ __('Customer Information') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="customer_name">{{ __('Customer Name') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                               value="{{ old('customer_name') }}" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="customer_email">{{ __('Customer Email') }} <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="customer_email" name="customer_email" 
                                               value="{{ old('customer_email') }}" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="customer_phone">{{ __('Customer Phone') }}</label>
                                        <input type="text" class="form-control" id="customer_phone" name="customer_phone" 
                                               value="{{ old('customer_phone') }}">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="customer_address">{{ __('Customer Address') }}</label>
                                        <textarea class="form-control" id="customer_address" name="customer_address" rows="3">{{ old('customer_address') }}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="billing_address">{{ __('Billing Address') }}</label>
                                        <textarea class="form-control" id="billing_address" name="billing_address" rows="3">{{ old('billing_address') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6>{{ __('Invoice Details') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="invoice_date">{{ __('Invoice Date') }} <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="invoice_date" name="invoice_date" 
                                                       value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="due_date">{{ __('Due Date') }} <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="due_date" name="due_date" 
                                                       value="{{ old('due_date') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="currency">{{ __('Currency') }} <span class="text-danger">*</span></label>
                                                <select class="form-control" id="currency" name="currency" required>
                                                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                                    <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                                    <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>CAD</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tax_rate">{{ __('Tax Rate (%)') }}</label>
                                                <input type="number" class="form-control" id="tax_rate" name="tax_rate" 
                                                       value="{{ old('tax_rate', 0) }}" min="0" max="100" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="discount_amount">{{ __('Discount Amount') }}</label>
                                        <input type="number" class="form-control" id="discount_amount" name="discount_amount" 
                                               value="{{ old('discount_amount', 0) }}" min="0" step="0.01">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="status">{{ __('Status') }}</label>
                                        <select class="form-control" id="status" name="status">
                                            @foreach(\App\Models\Invoice::getStatusOptions() as $key => $label)
                                                <option value="{{ $key }}" {{ old('status', 'draft') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="notes">{{ __('Notes') }}</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="terms_conditions">{{ __('Terms & Conditions') }}</label>
                                        <textarea class="form-control" id="terms_conditions" name="terms_conditions" rows="3">{{ old('terms_conditions') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Invoice Items -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6>{{ __('Invoice Items') }}</h6>
                        </div>
                        <div class="card-body">
                            <div id="invoice-items">
                                <div class="invoice-item row mb-3">
                                    <div class="col-md-5">
                                        <label>{{ __('Description') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="items[0][description]" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{ __('Quantity') }} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control quantity" name="items[0][quantity]" 
                                               min="0.01" step="0.01" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{ __('Unit Price') }} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control unit-price" name="items[0][unit_price]" 
                                               min="0" step="0.01" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>{{ __('Total') }}</label>
                                        <input type="text" class="form-control total-price" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-sm remove-item" style="display: none;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-success btn-sm" id="add-item">
                                <i class="fa fa-plus"></i> {{ __('Add Item') }}
                            </button>
                        </div>
                    </div>
                    
                    <!-- Totals -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6"><strong>{{ __('Subtotal:') }}</strong></div>
                                        <div class="col-6 text-right"><span id="subtotal">$0.00</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6"><strong>{{ __('Tax:') }}</strong></div>
                                        <div class="col-6 text-right"><span id="tax-amount">$0.00</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6"><strong>{{ __('Discount:') }}</strong></div>
                                        <div class="col-6 text-right"><span id="discount-display">$0.00</span></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6"><strong>{{ __('Total:') }}</strong></div>
                                        <div class="col-6 text-right"><strong><span id="total-amount">$0.00</span></strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Buttons -->
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> {{ __('Create Invoice') }}
                        </button>
                        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                            <i class="fa fa-times"></i> {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = 1;
            
            // Add item functionality
            document.getElementById('add-item').addEventListener('click', function() {
                const itemsContainer = document.getElementById('invoice-items');
                const newItem = document.querySelector('.invoice-item').cloneNode(true);
                
                // Update input names and clear values
                newItem.querySelectorAll('input').forEach(input => {
                    input.name = input.name.replace('[0]', '[' + itemIndex + ']');
                    input.value = '';
                });
                
                // Show remove button for all items except the first
                newItem.querySelector('.remove-item').style.display = 'block';
                
                itemsContainer.appendChild(newItem);
                itemIndex++;
                
                // Add remove functionality
                newItem.querySelector('.remove-item').addEventListener('click', function() {
                    newItem.remove();
                    calculateTotals();
                });
            });
            
            // Calculate totals on input change
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('quantity') || e.target.classList.contains('unit-price')) {
                    const row = e.target.closest('.invoice-item');
                    const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                    const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
                    const total = quantity * unitPrice;
                    row.querySelector('.total-price').value = total.toFixed(2);
                    calculateTotals();
                }
                
                if (e.target.id === 'tax_rate' || e.target.id === 'discount_amount') {
                    calculateTotals();
                }
            });
            
            function calculateTotals() {
                let subtotal = 0;
                
                document.querySelectorAll('.invoice-item').forEach(item => {
                    const total = parseFloat(item.querySelector('.total-price').value) || 0;
                    subtotal += total;
                });
                
                const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
                const discountAmount = parseFloat(document.getElementById('discount_amount').value) || 0;
                const taxAmount = subtotal * (taxRate / 100);
                const total = subtotal + taxAmount - discountAmount;
                
                document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
                document.getElementById('tax-amount').textContent = '$' + taxAmount.toFixed(2);
                document.getElementById('discount-display').textContent = '$' + discountAmount.toFixed(2);
                document.getElementById('total-amount').textContent = '$' + total.toFixed(2);
            }
            
            // Initial calculation
            calculateTotals();
        });
    </script>
@endsection

