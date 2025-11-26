@props(['seo'])

@section('page_title', $seo['title'])

@if(isset($seo['main_title']))
    @section('main_title', $seo['main_title'])
@endif

@section('seo')
    <meta name="robots" content="index, follow">
    <meta name="title" content="{{ $seo['meta_title'] }}">
    <meta name="description" content="{{ $seo['meta_description'] }}" />
    <meta name="keywords" content="">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $seo['meta_title'] }}">
    <meta itemprop="description" content="{{ $seo['meta_description'] }}">
    <meta itemprop="image" content="{{ $seo['image'] }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $seo['meta_title'] }}">
    <meta property="og:description" content="{{ $seo['meta_description'] }}">
    <meta property="og:image" content="{{ $seo['image'] }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $seo['meta_title'] }}">
    <meta property="twitter:description" content="{{ $seo['meta_description']    }}">
    <meta property="twitter:image" content="{{ $seo['image'] }}">
@endsection
