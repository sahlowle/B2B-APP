@extends('admin.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Attribute')]))

@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/mini-color/css/jquery.minicolors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/minicolor-override.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="attribute-edit-container">
        <div class="card">
            <div class="card-header">
                <h5> <a href="{{ route('attribute.index') }}">{{ __('Attributes') }} </a> >>{{ __('Edit :x', ['x' => __('Attribute')]) }}</h5>
            </div>
            <div class="card-block table-border-style">
                <div class="row form-tabs">
                    <form action="{{ route('attribute.update', $attributes->id) }}" method="post" id="attributeForm" class="form-horizontal col-sm-12" enctype="multipart/form-data">
                        @csrf
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-uppercase font-bold" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ __(':x Information',['x' => __('Attribute')]) }}</a>
                            </li>
                        </ul>
                        <div class="col-sm-12" id="myTabContent">
                               <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <li><a class="nav-link text-left active" id="v-pills-home-tab" data-bs-toggle="pill" href="#attribute" role="tab" aria-controls="v-pills-home" aria-selected="true">{{ __('Attribute') }}</a></li>
                                            <li id="secondli"><a class="nav-link text-left" id="v-pills-profile-tab" data-bs-toggle="pill" href="#attributeValue" role="tab" aria-controls="v-pills-profile" aria-selected="false">{{ __('Attribute :x', ['x' => __('Values')]) }}</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-9 col-sm-12 form-edit-con">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="attribute" role="tabpanel" aria-labelledby="v-pills-home-tab"  aria-hidden="true">
                                                <div class="form-group row">
                                                    <label for="name" class="control-label require ltr:ps-3 rtl:pe-3">{{ __('Name') }}
                                                    </label>
                                                    <div class="col-sm-12">
                                                        <input type="text" placeholder="{{ __('Name') }}" class="form-control form-width inputFieldDesign" id="name" name="name" value="{{ $attributes->name }}" required oninvalid="this.setCustomValidity(jsLang('This field is required.'))">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Type" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Type') }}</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control select2-hide-search" name="type" id="attrType">                                
                                                            <option value="color" {{ $attributes->type == "color" ? 'selected' : ''}}>{{ __('Color') }}</option>                        
                                                            <option value="dropdown" {{ $attributes->type == "dropdown" ? 'selected' : ''}}>{{ __('Dropdown') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="is_required" value="0">

                                                <div class="form-group row">
                                                    <label for="Status" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Status') }}</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control select2-hide-search" name="status" id="status">
                                                            <option value="Active" {{ $attributes->status == "Active" ? 'selected' : ''}}>{{ __('Active') }}</option>
                                                            <option value="Inactive" {{ $attributes->status == "Inactive" ? 'selected' : ''}}>{{ __('Inactive') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="is_filterable" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Is Filterable') }}</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-control select2-hide-search" name="is_filterable" id="is_filterable">
                                                            <option value="0" {{ old('is_filterable', $attributes->is_filterable) == "0" ? 'selected' : ''}}>{{ __('No') }}</option>
                                                            <option value="1" {{ old('is_filterable', $attributes->is_filterable) == "1" ? 'selected' : ''}}>{{ __('Yes') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="mt-12">
                                                        <span class="badge badge-warning ltr:me-1 rtl:ms-1">{{ __('Note') }}!</span>
                                                        <span>{{ __('Only filterable attributes should appear on the product filter page.') }}</span>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="description" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Description') }}
                                                    </label>
                                                    <div class="col-sm-12">
                                                        <textarea class="form-control form-width" name="description">{{ $attributes->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="attributeValue" role="tabpanel" aria-labelledby="v-pills-profile-tab" aria-hidden="true">
                                                <div class="table-responsive">
                                                    <table class="options table table-bordered" id="attribute-value">
                                                        <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>{{ __('Value') }}</th>
                                                            <th class="colorCode">{{ __('Color Code') }}</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="values">
                                                        @php $rowId = 1  @endphp
                                                        @foreach ($attributeValues as $value)
                                                            <tr draggable="false" id="rowid-{{ $rowId }}">
                                                                <td class="text-center handle">
                                                                    <i class="fa fa-bars"></i>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" name="values[]" value="{{ $value->value }}" class="form-control inputFieldDesign attribute-value" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')" id="valueChk-{{ $rowId }}">
                                                                        <span id="value-text-{{ $rowId }}" class="validationMsg"></span>
                                                                        <input type="hidden" name="row_identify[]" value="{{ $rowId }}">
                                                                        <input type="hidden" name="value_id[]" value="{{ $value->id }}" class="form-control">
                                                                    </div>
                                                                </td>
                                                                <td class="colorCode">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control demo inputFieldDesign" data-control="hue"  name="additional_values[]" value="{{ $value->additional_values }}">
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" id="delete-value" class="btn btn-xs btn-danger delete-row" data-row-id={{ $rowId++ }} data-bs-toggle="tooltip" data-bs-title="Delete Value" data-original-title="">
                                                                        <i class="feather icon-trash-2"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <input type="hidden" id="row_id" value="{{ $rowId }}">
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button type="button" class="btn btn-default" id="add-new-value">{{ __('Add') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-sm-10 px-0 m-l-5">
                                <a href="{{ route('attribute.index') }}" class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                                <button class="btn custom-btn-submit" type="submit" id="btnSubmit"><i class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span id="spinnerText">{{ __('Update') }}</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/attribute.min.js?v=2.8') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/js/pages/form-picker-custom.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/mini-color/js/jquery.minicolors.min.js') }}"></script>
@endsection
