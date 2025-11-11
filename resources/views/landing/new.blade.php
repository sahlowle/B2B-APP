@extends('site.layouts.app')
@php
    $displayPrice = preference('display_price_in_shop');
    
    $homeService = new \Modules\CMS\Service\HomepageService();
    if (isset($slug)) { // if this is not default home page
        $slides = \Modules\CMS\Http\Models\Slide::whereHas('slider', function ($query) {
            $query->where(['slug' => 'home-page', 'status' => 'Active']);
        })->get();
        
        $page = Modules\CMS\Entities\Page::where('slug', $slug)->with(['components' => function ($q) {
            $q->with(['properties', 'layout:id,file'])->orderBy('level', 'asc');
        }])->first();
    } else {            
        $slides = \Modules\CMS\Http\Models\Slide::whereHas('slider', function ($query) {
            $query->where(['slug' => option('default_template_page', 'home-slider')['slider'], 'status' => 'Active']);
        })->get();
        
        $page = $homeService->home();

        if (! auth()->check() && isActive('Affiliate')) {
            \Modules\Affiliate\Entities\Referral::userClickUpdate();
        }
    }
@endphp

@section('page_title', $page->meta_title)

@section('seo')

    @php
        $fileUrl = asset("public/frontend/img/logo.png");
    @endphp

    <meta name="robots" content="index, follow">
    <meta name="title" content="{{ $page->meta_title ?? $page->title }}">
    <meta name="description" content="{{ $page->meta_description }}" />
    <meta name="keywords" content="">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $page->meta_title ?? $page->title }}">
    <meta itemprop="description" content="{{ $page->meta_description }}">
    <meta itemprop="image" content="{{ $fileUrl }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $page->meta_title ?? $page->title }}">
    <meta property="og:description" content="{{ $page->meta_description }}">
    <meta property="og:image" content="{{ $fileUrl }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $page->meta_title ?? $page->title }}">
    <meta property="twitter:description" content="{{ $page->meta_description }}">
    <meta property="twitter:image" content="{{ $fileUrl }}">
@endsection


@section('css')

@endsection


@section('content')
    @include('landing.includes.hero')
    @include('landing.includes.features')
    @include('landing.includes.services')
    @include('landing.includes.cta')
    @include('landing.includes.industry')

@endsection

@section('js')

    <script>
        const ajaxLoadUrl = "{{ route('ajax-product') }}"
    </script>

    <script src="{{ asset('public/dist/js/custom/site/home.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/slick/slick.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/common.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/wishlist.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/compare.min.js') }}"></script>
@endsection
