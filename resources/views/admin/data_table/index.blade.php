@extends('admin.layouts.app')
@section('page_title', __('Data Table'))
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="datatable_container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10  ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.general_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <span id="smtp_head">
                            <div class="card-header p-t-20 border-bottom">
                                <h5>{{ __('Data Table') }}</h5>
                            </div>
                        </span>
                        
                        <form action="{{ route('datatables.store') }}" method="POST" class="mt-3">
                            @csrf
                            <div class="card-body px-2 ">
                                <div class="row p-l-15">
                                    <div class="form-group row">
                                        <label id="default-language" class="col-sm-3 control-label "
                                            for="inputEmail3">{{ __('Minimum Search Length') }}</label>
    
                                        <div class="col-sm-7">
                                            <select name="dt_minimum_search_length" id="dt_minimum_search_length"
                                                class="form-control js-example-basic-single form-height select2-hide-search">
                                                @foreach (range(1, 10) as $i)
                                                    <option  value="{{ $i }}" @selected(preference('dt_minimum_search_length', 3) == $i)>
                                                        {{ $i }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-7 offset-md-3 mt-2">
                                            <span class="badge badge-primary">{{ __('Note') }}!</span> {{ __('The minimum number of characters the user must type before a search is performed') }}
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label id="default-language" class="col-sm-3 control-label "
                                            for="inputEmail3">{{ __('Search Delay') }}</label>
    
                                        <div class="col-sm-7">
                                            <select name="dt_search_delay" id="dt_search_delay"
                                                class="form-control js-example-basic-single form-height select2-hide-search">
                                                @foreach (range(100, 1000, 100) as $i)
                                                    <option  value="{{ $i }}" @selected(preference('dt_search_delay', 500) == $i)>
                                                        {{ $i }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-7 offset-md-3 mt-2">
                                            <span class="badge badge-primary">{{ __('Note') }}!</span> {{ __('The number of milliseconds the user must wait after a keystroke before the search is performed') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <div class="form-group row">
                                    <label for="btn_save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-12">
                                        <button type="submit"
                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left save-button"
                                            id="footer-btn">
                                            <span
                                                class="d-none product-spinner spinner-border spinner-border-sm text-secondary"
                                                role="status"></span>
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
