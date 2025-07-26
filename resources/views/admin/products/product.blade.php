@extends('admin.layouts.app')
@section('page_title')
    @if (isset($product))
        {{ $product->name }} - {{ __('Edit :x', ['x' => __('Product')]) }}
    @else
        {{ __('Create new item') }}
    @endif
@endsection

@push('styles')
    <!-- summer note css -->
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.css') }}">
    <!-- custom category -->
    <link rel="stylesheet" href="{{ asset('public/dist/css/custom-category.min.css') }}">
    <!-- date range picker css -->
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/mini-color/css/jquery.minicolors.min.css') }}">
    <style>
        .minicolors{
            position: absolute;
        }
    </style>
@endpush
@section('content')
    @php
        $isAdmin = true;
        $productForSelector = isset($product) ? $product : null;
    @endphp
    <!-- Main content -->
    <div class="col-md-12 no-print notification-msg-bar smoothly-hide">
        <div class="noti-alert pad">
            <div class="alert bg-dark text-light m-0 text-center">
                <span class="notification-msg"></span>
            </div>
        </div>
    </div>

    @php
        $sections = (new \App\Services\Product\Editor\Section($productForSelector))->getSections()['sections'];
    @endphp

    <div class="col-md-12 overflow-x-hidden list-container" id="invoice-view-container">
        <div class="row">
            @csrf
            <div class="col-md-12 col-lg-12 col-xl-9 order-last order-xl-first">
                @foreach ($sections as $name => $section)
                    @if (
                        ($section['visibility'] ?? '1') == '1' &&
                            !($section['is_left_side'] ?? false) &&
                            ($section['is_main'] ?? false) &&
                            !($section['is_draggable'] ?? false))
                        @if (is_callable($section['content']))
                            {!! $section['content']() !!}
                        @else
                            @includeIf($section['content'])
                        @endif
                    @endif
                @endforeach

                <div id="sortable" class="drag_and_drop">
                    @foreach ($sections as $name => $section)
                        @if (
                            ($section['visibility'] ?? '1') == '1' &&
                                !($section['is_left_side'] ?? false) &&
                                ($section['is_main'] ?? false) &&
                                ($section['is_draggable'] ?? false))
                            @if (is_callable($section['content']))
                                {!! $section['content']() !!}
                            @else
                                @includeIf($section['content'])
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="col-md-12 col-lg-12 col-xl-3">
                @foreach ($sections as $name => $section)
                    @if (($section['visibility'] ?? '1') != '1' || ($section['is_main'] ?? false))
                        @continue
                    @endif

                    @if ($section['is_left_side'] ?? false)
                        @if (is_callable($section['content']))
                            {!! $section['content']() !!}
                        @else
                            @includeIf($section['content'])
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <form
        action="{{ isset($product) ? route('products.edit-action', ['code' => $product->code, 'lang' => request()->input('lang', config('app.locale'))]) : route('product.create', ['lang' => request()->input('lang', config('app.locale'))]) }}"
        method="post" id="ajaxReloadForm">
        @csrf
        <input type="hidden" name="action" class="ajax-form-action">
        <input type="hidden" name="data" class="ajax-form-data">
    </form>

    @include('admin.layouts.includes.delete-modal')
    @include('admin.products.sections.sub.attribute-modal')
    @include('mediamanager::image.modal_image')
    @php
        $parentCategory = null;
        $parentCategoryId = null;
    @endphp
@endsection

@section('js')
    <!-- Jquery Ui JS -->
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <!-- sweetalert JS -->
    <script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/delete-modal.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/product.min.js?v=3.2') }}"></script>
    <script src="{{ asset('public/datta-able/js/pages/form-picker-custom.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/mini-color/js/jquery.minicolors.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/custom-category.min.js') }}"></script>
    <script>
        var parentCategoryId = {{ isset($product) ? json_encode($parentCategoryId) : json_encode([]) }}
        parentCategoryId != '' ? buttonIsDisable = false : '';
        loadListProduct(false);
        var confirmTextCurrentSection = '';
    </script>
    @if (!empty($parentCategory))
        @foreach (explode(' / ', $parentCategory) as $key => $parent)
            <script>
                confirmTextCurrentSection +=
                    `<li class="breadcrumb-item" data-catId = {{ $parentCategoryId[$key] ?? null }}><a class="custom-a" href="javascript:void(0)">{{ $parent }}</a></li>`;
            </script>
        @endforeach
    @endif
    <script>
        let itemUrl =
            '{{ isset($product) ? route('products.edit-action', ['code' => $product->code, 'lang' => request()->input('lang', config('app.locale')) ]) : route('product.create', ['lang' => request()->input('lang', config('app.locale'))]) }}';
        let itemsAjaxSearch =
            '{{ isset($product) ? route('findProductsAjax', ['code' => $product->code]) : route('findProductsAjax') }}';
        let tagsAjaxSearch = '{{ route('findTagsAjax') }}';
        let variationImagePlaceholder = '{{ asset('public/dist/img/not.svg') }}';
        const countHelper = {
            attributes: 0,
            variations: 0
        }
        var videoExtensions = @json(getFileExtensions(6));
        var currentProductUrl = '{{ isset($product) ? route('product.edit', $product->code) : route('product.create') }}';
        var selectedLang = '{{ request()->input('lang', config('app.locale')) }}';
        var isDisableMultivendor = '{{ isActive('Disablemultivendor') && preference('is_active_single_vendor') == 1 }}';

    </script>

    <script src="{{ asset('public/dist/js/xss.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/create-product.min.js?v=3.2') }}"></script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <!-- date range picker Js -->
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <!-- summernote JS -->
    <script src="{{ asset('public/datta-able/plugins/summer-note/summernote-lite.min.js') }}"></script>
    @if(isActive('Inventory'))
        <script src="{{ asset('Modules/Inventory/Resources/assets/js/product_stock.min.js') }}"></script>
    @endif
@endsection
