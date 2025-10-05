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

                <form action="{{ route('invoices.store') }}" method="post" id="invoiceForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
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
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currency">{{ __('Currency') }} <span class="text-danger">*</span></label>
                                <select class="form-control" id="currency" name="currency" required>
                                    <option value="">{{ __('Select One') }}</option>
                                    @foreach(getCurrencies() as $currency)
                                        <option value="{{ $currency }}" {{ old('currency') == $currency ? 'selected' : '' }}>
                                            {{ $currency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_amount">{{ __('Total Amount') }} <span class="text-danger">*</span></label>
                                <input type="number" placeholder="2,000.00" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" min="1" step="0.01" required>
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
        (function(){
            var dz = document.getElementById('dropzone');
            var fileInput = document.getElementById('invoice_file');
            var info = document.getElementById('file-info');
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
            }

            function clearInfo(){
                info.style.display = 'none';
                info.innerHTML = '';
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

