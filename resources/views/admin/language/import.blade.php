@extends('admin.layouts.app')
@section('page_title', __('Language Import'))

@section('content')
<div>
    <div class="card pb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5><a href="{{ route('language.index') }}">{{ __('Languages') }}</a> <span class="feather icon-chevrons-right"></span> {{ __('Import :x Language', ['x' => $language->name]) }}</h5>
            </div>
        </div>
        <div class="card-body row">
            <div class="offset-sm-3 col-sm-6">
                <div>
                    @if ($missingKeys)
                        <div class="form-group">
                            <label class="col-sm-12 text-left col-form-label">
                                {{ __('To confirm, type "import" below.') }}</label>
                            <div class="col-sm-12">
                                <div class="custom-file position-relative">
                                    <input type="text" class="form-control inputFieldDesign" id="confirm_import" placeholder="{{ __('Type "import"') }}">
                                    <small id="emailHelp" class="form-text text-muted">{{ __('It may take some time to
                                        import the language. Please wait until the process is completed.') }}</small>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="alert alert-success">
                        <b class="d-block">
                            {{ __('Total missing sentence found: :x', ['x' => $missingKeys]) }}
                        </b>
                    </div>
                    
                    @isset($warningMessage)
                        <div class="alert alert-warning">
                            <b class="d-block">
                                {{ $warningMessage }}
                            </b>
                        </div>
                    @endisset
                    
                    @if ($missingKeys)
                        <div class="alert alert-warning">
                            <b class="d-block">
                                {{ __('Your modified data will not be changed. Only missing sentences will be imported.') }}
                            </b>
                        </div>
                        
                        <form action="{{ route('language.import', ['id' => $language->id]) }}" class="form-horizontal from-class-id" method="POST">
                            @csrf
                            
                            <div class="col-sm-12 px-0 m-l-10 mt-3 pr-0 d-flex justify-content-end">
                                <a href="{{ route('language.index') }}" class="btn custom-btn-cancel all-cancel-btn" type="submit">{{ __('Cancel') }}</a>
                                <button class="btn btn-danger import_now_btn" disabled type="submit">{{ __('Import Now') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
