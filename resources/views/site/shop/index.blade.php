@extends('site.layouts.app')
@php
    // $shop gets from controller
    $allProducts = App\Models\Product::where('vendor_id', $shop->vendor_id)->notVariation()->paginate(25);
    $displayPrice = preference('display_price_in_shop');
    $topSellerIds = App\Models\Vendor::topSeller()->pluck('vendor_id')->toArray();
    $vendor = App\Models\Vendor::with('reviews', 'shops')->where('id', $shop->vendor_id)->first();
    $reviewCount = $vendor->reviews->where('status', 'Active')->count();
    $avg = $vendor->reviews->where('status', 'Active')->avg('rating');
    $positiveRating = App\Models\Product::positiveRating($shop->vendor_id);

    $displayPrice = preference('display_price_in_shop');
    $homeService = $homeService = new \Modules\CMS\Service\HomepageService();
    $vendorPage = $homeService->home($shop->vendor_id);
@endphp
@section('page_title', $vendor->name)
@section('seo')
    @include('site.shop.seo', ['page' => $vendorPage])
@endsection
@section('content')
    <section class="layout-wrapper px-4 xl:px-0 ">
        {{-- profile and top benner --}}
        @include('site.shop.top-banner')
        
        @if(empty($vendorPage) || preference('is_vendor_shop_decoration_active', '') != 1)
            {{-- menu items and search --}}
            @include('site.shop.menu')

            <!-- All product section start -->
            @include('site.layouts.section.shop.products')
            <!-- All product section end -->
        @else
            @foreach ($vendorPage->components as $component)
                @include('cms::templates.blocks.' . $component->layout->file)
            @endforeach
        @endif
    </section>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/site/wishlist.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/compare.min.js') }}"></script>
    
    <script>
        const ajaxLoadUrl = "{{ route('vendor.ajax-product') }}"
    </script>
    <script src="{{ asset('public/dist/js/custom/site/home.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/slick/slick.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/common.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/wishlist.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/compare.min.js') }}"></script>
@endsection
