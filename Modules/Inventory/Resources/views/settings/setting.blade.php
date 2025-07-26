@extends('admin.layouts.app')
@section('page_title', __('Product Setting'))

@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/CMS/Resources/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
@endsection

@section('content')
    <div class="col-sm-12">
        <div class="card admin-panel-product-setting" id="inventory-setting-container">
            <div class="card-body row">
                <div class="col-lg-3 col-12 z-index-10  ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0"
                     aria-labelledby="navbarDropdown">
                    <div class="card card-info shadow-none">
                        <div class="card-header p-t-20 border-bottom mb-2">
                            <h5>{{ __('Inventory Setting') }}</h5>
                        </div>
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li><a class="nav-link text-left tab-name active" id="v-pills-inventory-tab" data-bs-toggle="pill"
                                   href="#v-pills-inventory" role="tab" aria-controls="v-pills-inventory"
                                   aria-selected="true" data-id={{ __('Inventory') }}>{{ __('Order') }}
                            </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5 id="theme-title">{{ __('Order') }}</h5>
                        </div>

                        <div class="tab-content" id="topNav-v-pills-tabContent">
                            {{-- Inventory --}}
                            <div class="tab-pane fade parent mt-1p active show" id="v-pills-inventory" role="tabpanel"
                                 aria-labelledby="v-pills-inventory-tab">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form action="{{ route('inventory.settings') }}" method="post"
                                              class="form-horizontal inventory_setting_form">
                                            @csrf
                                            <div class="card-body border-bottom table-border-style p-0">
                                                <div class="form-tabs">
                                                    <div class="tab-content box-shadow-unset px-0 py-2">
                                                        <div class="tab-pane fade show active" id="home"
                                                             role="tabpanel" aria-labelledby="home-tab">
                                                            <div class="form-group row">
                                                                <label for="stock_display_format"
                                                                       class="col-sm-3 control-label text-left">{{ __('Order fulfill') }}</label>
                                                                <div class="col-md-9 col-12">
                                                                    <div class="row radio">
                                                                        <div class="col-sm-12 mb-2">
                                                                            <div class="mb-2 radio radio-warning d-inline">
                                                                                <input type="radio" id="highest"
                                                                                       name="order_fulfill"
                                                                                       {{ preference('order_fulfill') ? '' : 'checked' }}
                                                                                       value="highest"
                                                                                    {{ preference('order_fulfill', '') == 'highest' ? 'checked' : '' }}>
                                                                                <label class="cr custom"
                                                                                       for="highest"></label>
                                                                                <label
                                                                                    class="w-75">{{ __("From highest location to priority order") }}</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 mb-2">
                                                                            <div class="mb-2 radio radio-warning d-inline">
                                                                                <input type="radio" id="default"
                                                                                       name="order_fulfill"
                                                                                       value="default"
                                                                                    {{ preference('order_fulfill', '') == 'default' ? 'checked' : '' }}>
                                                                                <label class="cr custom"
                                                                                       for="default"></label>
                                                                                <label
                                                                                    class="w-75">{{ __("Default/Primary location") }}</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-12">
                                                                            <span class="badge badge-warning ltr:me-1 rtl:ms-1">{{ __('Note') }}!</span>
                                                                            <span>{{ __('While order/refund stock will reduce/add based on settings') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                            {{-- Vendor --}}
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/inventory-setting.js') }}"></script>
@endsection
