@extends('admin.layouts.app')
@section('page_title', __('Geo Locale Import'))

@section('content')
<div>
    <div class="card pb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5>{{ __('Import Geo Locale Data') }}</h5>
            </div>
        </div>
        <div class="card-body row">
            <div class="offset-sm-3 col-sm-6">
                <div>
                    <div class="form-group">
                        <label class="col-sm-12 text-left col-form-label">
                            {{ __('To confirm, type "import" below.') }}</label>
                        <div class="col-sm-12">
                            <div class="custom-file position-relative">
                                <input type="text" class="form-control inputFieldDesign" id="confirm_import" placeholder="{{ __('Type "import"') }}">
                                <small id="emailHelp" class="form-text text-muted">{{ __('It may take some time to
                                    import the database. Please wait until the process is completed.') }}</small>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('geolocale.import') }}" class="form-horizontal from-class-id" method="POST">
                        @csrf
                        <div class="alert alert-warning">
                            <b class="d-block mt-2">
                                {{ __('You will lose all the geo locale data you have inserted, and new geo locale data will be set after the import.') }}
                            </b>
                            <b class="d-block mt-2">{{ __('Before performing the action, it is strongly recommended to create a full backup of your current installation (files and database)') }}
                                <a href="https://help.techvill.net/backup-martvill-files-and-database/" target="_blank"><i class="feather icon-external-link"></i> {{ __('See backup documentation') }}</a>
                            </b>
                        </div>
                        
                        @php
                            $prevUrl = url()->previous();
                            $defaultUrl = route('epz.imports');
                            $routesToCheck = collect([route('geolocale.index'), $defaultUrl]);

                            $cancelUrl = $routesToCheck->contains($prevUrl) ? $prevUrl : $defaultUrl;
                        @endphp
                        
                        <div class="col-sm-12 px-0 m-l-10 mt-3 pr-0 d-flex justify-content-end">
                            <a href="{{ $cancelUrl }}" class="btn custom-btn-cancel all-cancel-btn" type="submit">{{ __('Cancel') }}</a>
                            <button class="btn btn-danger import_now_btn" disabled type="submit">{{ __('Import Now') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('Modules/Dummy/Resources/assets/js/app.min.js') }}"></script>
@endsection
