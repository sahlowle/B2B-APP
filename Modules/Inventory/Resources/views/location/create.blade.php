@extends('admin.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Location')]))

@section('css')

@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="location-add-container">
        <div class="card">
            <div class="card-header">
                <h5> <a href="{{ route('location.index') }}">{{ __('Locations') }} </a>
                    >>{{ __('Create :x', ['x' => __('Location')]) }}</h5>
            </div>
            <div class="card-block table-border-style">
                <div class="row form-tabs">
                    <form action="{{ route('location.store') }}" method="post"
                          class="form-horizontal col-sm-12" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link font-bold active text-uppercase" id="home-tab" data-bs-toggle="tab" href="#home"
                                   role="tab" aria-controls="home"
                                   aria-selected="true">{{ __(':x Information', ['x' => __('Location')]) }}</a>
                            </li>
                        </ul>
                        <div class="col-sm-12 tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                 aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-sm-9">

                                        <div class="form-group row">
                                            <label for="country"
                                                   class="col-sm-3 control-label require">{{ __('Vendor') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control addressSelect sl_common_bx" name="vendor_id" id="vendor_id" required
                                                        oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                    <option value="">{{ __('Select One') }}</option>
                                                    @foreach($vendors as $vendor) 
                                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 control-label require">{{ __('Name') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="{{ __('Name') }}"
                                                       class="form-control inputFieldDesign" id="name" name="name"
                                                       value="{{ old('name') }}" required maxlength="80"
                                                       oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="slug" class="col-sm-3 control-label require">{{ __('Slug') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="{{ __('Slug') }}"
                                                       class="form-control inputFieldDesign" id="slug" name="slug"
                                                       value="{{ old('slug') }}" required maxlength="80"
                                                      
                                                       >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email"
                                                   class="col-sm-3 control-label">{{ __('Email') }}</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control inputFieldDesign bg-white"
                                                       id="email" name="email" value="{{ old('email') }}"
                                                       placeholder="{{ __('Email') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="phone"
                                                   class="col-sm-3 control-label">{{ __('Phone') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="{{ __('Phone') }}"
                                                       class="form-control phone-number inputFieldDesign" id="phone"
                                                       name="phone" value="{{ old('phone') }}">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="form-group row">
                                            <label for="address"
                                                   class="col-sm-3 control-label">{{ __('Address') }}</label>
                                            <div class="col-sm-9">
                                                <textarea placeholder="{{ __('Address') }}" id="address" class="form-control" name="address" 
                                                          >{{ old('address') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="country"
                                                   class="col-sm-3 control-label">{{ __('Country') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control addressSelect sl_common_bx" name="country" id="country">
                                                    
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="state"
                                                   class="col-sm-3 control-label">{{ __('State') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control addressSelect sl_common_bx" name="state" id="state">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="city"
                                                   class="col-sm-3 control-label">{{ __('City') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control addressSelect sl_common_bx" name="city" id="city">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="zip"
                                                   class="col-sm-3 control-label">{{ __('Zip') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="{{ __('Zip') }}"
                                                       class="form-control inputFieldDesign" id="zip"
                                                       name="zip" value="{{ old('zip') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="Status"
                                                   class="col-sm-3 control-label require">{{ __('Status') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                        name="status" id="status">
                                                    <option value="Active"
                                                        {{ old('status') == 'Active' ? 'selected' : '' }}>
                                                        {{ __('Active') }}</option>
                                                    <option value="Inactive"
                                                        {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                                        {{ __('Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="Status"
                                                   class="col-sm-3 control-label require">{{ __('Default') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                        name="is_default" id="is_default">
                                                    <option value="0"
                                                        {{ old('is_default') == '0' ? 'selected' : '' }}>
                                                        {{ __('No') }}</option>
                                                    <option value="1"
                                                        {{ old('is_default') == '1' ? 'selected' : '' }}>
                                                        {{ __('Yes') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10 px-0 mt-3 mt-md-0">
                                <a href="{{ route('location.index') }}"
                                   class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                                <button class="btn custom-btn-submit" type="submit" id="btnSubmit"><i
                                        class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                                        id="spinnerText">{{ __('Create') }}</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        'use strict';
        let oldCountry = "{!! old('country') ?? 'null' !!}";
        let oldState = "{!! old('state') ?? 'null' !!}";
        let oldCity = "{!! old('city') ?? 'null' !!}";
        let url = "{{ URL::to('/') }}";
    </script>
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('Modules/Inventory/Resources/assets/js/location.min.js') }}"></script>
@endsection
