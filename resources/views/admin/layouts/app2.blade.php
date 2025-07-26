<!DOCTYPE html>
<html>

<head>
    <title>{{ trimWords(preference('company_name'), 17) }} | @yield('page_title', env('APP_NAME', ''))</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @include('admin.layouts.includes.meta')
    <!-- Favicon icon -->
    @php
        $favicon = App\Models\Preference::getFavicon()
    @endphp
    @if(!empty($favicon))
        <link rel='shortcut icon' href="{{ $favicon }}" type='image/x-icon' />
    @endif
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/animation/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/bootstrap-v5/css/bootstrap.min.css') }}">
    @if(file_exists(base_path('public/js/lang/' . config('app.locale') . '.js')))
        <script src="{{ asset('public/js/lang/' . config('app.locale') . '.js') }}"></script>
    @else
        <script type="text/javascript">const translates = {}</script>
    @endif
    <link rel="stylesheet" href="{{ asset('public/datta-able/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/feather/css/feather.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/jquery-scrollbar/css/jquery.scrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/datta/datta-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/jquery-scrollbar/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/login.min.css') }}">
    @yield('css')
    <script type="text/javascript">
        'use strict';
        var SITE_URL              = "{{ URL::to('/') }}";
        var currencySymbol        = '{!! currency()->symbol !!}';
        var decimal_digits        = '{!! preference('decimal_digits') !!}';
        var thousand_separator    = '{!! preference('thousand_separator') !!}';
        var symbol_position       = '{!! preference('symbol_position') !!}';
        var dateFormat            = '{!! preference('date_format_type') !!}';
        var token                 = '{!! csrf_token() !!}';
        var app_locale_url        = "{!! url('/resources/lang/' . config('app.locale') . '.json') !!}";
        var row_per_page          = '{!! preference('row_per_page') !!}';
        var language_direction    = '{!! \Cache::get(config('cache.prefix') . '-language-direction') !!}';
    </script>
</head>
<body>
    @yield('content')
 <script>
        var loginNeeded=false;
 </script>
    @yield('js')
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/slim.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/login.min.js')}}"></script>
    <script src="{{ asset('public/dist/js/custom/site/be-seller.min.js')}}"></script>

</body>
</html>
