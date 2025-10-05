@extends('admin.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Invoice')]))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5> 
                    <a href="{{ route('invoices.index') }}">{{ __('Invoices') }}</a>
                    > {{ __('Edit :x', ['x' => __('Invoice')]) }} #{{ $invoice->invoice_number }}
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

                <form action="{{ route('invoices.update', $invoice) }}" method="post" id="invoiceForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-12">
                            <label>{{ __('Invoice File (optional)') }}</label>
                            <div id="dropzone" style="border: 2px dashed #ccc; padding: 25px; text-align: center; cursor: pointer; border-radius: 6px; transition: border-color .2s, background-color .2s;">
                                <i class="fa fa-cloud-upload"></i>
                                <p class="mb-1">{{ __('Drag & drop file here or click to upload') }}</p>
                                <small class="text-muted">{{ __('Max size 5MB. Accepted: PDF, images') }}</small>
                                </div>
                            <input type="file" id="invoice_file" name="invoice_file" accept="application/pdf,image/*" style="display:none;">
                            <div id="file-info" class="mt-2" style="display:none;"></div>
                            @if($invoice->invoice_file)
                                <div id="current-file" class="mt-2">
                                    <div style="display:flex;align-items:center;justify-content:space-between;background:#e8f5e8;border:1px solid #4caf50;border-radius:6px;padding:8px 12px;">
                                        <div style="display:flex;align-items:center;min-width:0;">
                                            <i class="fa fa-file" style="margin-right:8px;color:#4caf50;"></i>
                                            <div style="min-width:0;">
                                                <div style="font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:360px;">
                                                   Invoice File
                                                </div>
                                                <small class="text-muted">Current file</small>
                                    </div>
                                    </div>
                                        <a href="{{ route('invoices.pdf', $invoice) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="fa fa-file-pdf"></i> 
                                            {{ __('download') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            </div>
                        </div>
                        
                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="currency">{{ __('Currency') }} <span class="text-danger">*</span></label>
                                                <select class="form-control" id="currency" name="currency" required>
                                                    <option value="">{{ __('Select One') }}</option>
                                                    @foreach(getCurrencies() as $currency)
                                                        <option value="{{ $currency }}" {{ old('currency', $invoice->currency) == $currency ? 'selected' : '' }}>
                                                            {{ $currency }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                <label for="total_amount">{{ __('Total Amount') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount', $invoice->total_amount) }}" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> {{ __('Update Invoice') }}
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
        (function(){
            var dz = document.getElementById('dropzone');
            var fileInput = document.getElementById('invoice_file');
            var info = document.getElementById('file-info');
            var currentFile = document.getElementById('current-file');
            var maxBytes = 5 * 1024 * 1024; // 5MB

            function isImage(file){ return /^image\//.test(file.type); }

            function setInfo(file){
                var name = file.name;
                var sizeKb = Math.round(file.size/1024);
                var preview = '';
                if (isImage(file)) {
                    var url = URL.createObjectURL(file);
                    preview = '<img src="' + url + '" alt="preview" style="height:40px;width:auto;margin-right:8px;border-radius:4px;object-fit:cover;">';
                }
                info.style.display = 'block';
                info.innerHTML = '<div style="display:flex;align-items:center;justify-content:space-between;background:#f7f7f9;border:1px solid #e1e1e6;border-radius:6px;padding:8px 12px;">'
                    + '<div style="display:flex;align-items:center;min-width:0;">' + preview
                    + '<div style="min-width:0;">'
                    + '<div style="font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:360px;">' + name + '</div>'
                    + '<small class="text-muted">' + sizeKb + ' KB</small>'
                    + '</div>'
                    + '</div>'
                    + '<button type="button" id="remove-file" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> {{ __('Remove') }}</button>'
                    + '</div>';
                var removeBtn = document.getElementById('remove-file');
                removeBtn.addEventListener('click', function(){
                    clearFile();
                });
                // Hide current file when new file is selected
                if (currentFile) currentFile.style.display = 'none';
            }

            function clearInfo(){
                info.style.display = 'none';
                info.innerHTML = '';
                // Show current file again when new file is removed
                if (currentFile) currentFile.style.display = 'block';
            }

            function clearFile(){
                fileInput.value = '';
                clearInfo();
            }

            dz.addEventListener('click', function(){ fileInput.click(); });

            ;['dragenter','dragover'].forEach(function(evt){
                dz.addEventListener(evt, function(e){ e.preventDefault(); e.stopPropagation(); dz.style.borderColor = '#4caf50'; dz.style.backgroundColor = '#f4fff6'; });
            });
            ;['dragleave','drop'].forEach(function(evt){
                dz.addEventListener(evt, function(e){ e.preventDefault(); e.stopPropagation(); dz.style.borderColor = '#ccc'; dz.style.backgroundColor = 'transparent'; });
            });
            dz.addEventListener('drop', function(e){
                var files = e.dataTransfer.files;
                if(!files || !files.length) return;
                var file = files[0];
                if(file.size > maxBytes){
                    alert('File is larger than 5MB.');
                    clearInfo();
                    fileInput.value = '';
                    return;
                }
                fileInput.files = files;
                setInfo(file);
            });

            fileInput.addEventListener('change', function(){
                if(!fileInput.files || !fileInput.files.length){ clearInfo(); return; }
                var file = fileInput.files[0];
                if(file.size > maxBytes){
                    alert('File is larger than 5MB.');
                    fileInput.value = '';
                    clearInfo();
                    return;
                }
                setInfo(file);
            });
        })();
    </script>
@endsection
