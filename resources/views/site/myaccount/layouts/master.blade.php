{{-- This is a secondary layer between pages and the master layout to inject styles and scripts easily --}}

{{-- Extending master layout --}}
@extends('site.layouts.master')

{{-- All the contents will be placed here --}}
@section('parent-content')
    <div class="layout-wrapper px-4 xl:px-0">
        @include('site.myaccount.layouts.breadcrumb')
        <div class="flex justify-start xl:gap-16 gap-5" x-cloak>
            @include('site.myaccount.layouts.sidebar')
            @yield('content')
        </div>
    </div>

    @if (isActive('Ticket') && preference('chat'))
        @include('ticket::message')
    @endif
@endsection

{{-- All the styles will be injected here --}}
@section('parent-css')
    @yield('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    @stack('styles')
@endsection

{{-- All the scripts will be injected here --}}
@section('parent-js') 
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    
    @yield('js')
    
    <script src="{{ asset('public/js/myaccount.min.js') }}"></script>
    @stack('scripts')
@endsection
