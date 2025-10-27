<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ languageDirection() }}">

<head>

    @doAction('after_site_head')

    @includeIf('googleanalytics::partials.google_analytics_header')

    <title>{{ trimWords(preference('company_name'), 17) }} | @yield('page_title', env('APP_NAME', ''))</title>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    @yield('seo')
    
    @php
        $themeOption = \Modules\CMS\Http\Models\ThemeOption::getAll();

        $layout = 'default';
        
        if (!isset($page->layout)) {
            $page = \Modules\CMS\Entities\Page::firstWhere('default', '1');
        }
        $layout = $page->layout;
        $primaryColor = option($layout . '_template_primary_color', '#FCCA19');

        [$fontFamily, $genericFamily] = explode(',', option($layout . '_template_font_family', 'DM Sans, sans-serif'));
         $multiCurrencies  = \App\Models\MultiCurrency::getAll();
         $defaultMulticurrency = defaultMulticurrencyData($multiCurrencies);

         if(app()->getLocale() === 'ar'){
            $fontFamily = 'Droid Arabic Naskh';
            $genericFamily = 'serif';
         }

    @endphp

    @if(app()->getLocale() === 'ar')    
    <style>
        @import url(https://fonts.googleapis.com/earlyaccess/droidarabicnaskh.css);
    </style>
    @endif

   <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --global-font: {{ $fontFamily . ',' . $genericFamily }};
            --semi-primary-color: {{ $primaryColor . '11' }};
            --sw-anchor-active-primary-color: {{ $primaryColor }} !important;
            --sw-anchor-done-primary-color: {{ lighten_color($primaryColor, 50) }} !important;
        }
    </style>
    
    <link rel="stylesheet" href="{{ asset('public/dist/css/intl-tel-input/intlTelInput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/app.min.css?v=2.5') }}" />
    <link rel="stylesheet" href="{{ asset('public/css/tailwind-custom.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/google-font-roboto.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/datta-able/fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.css') }}" type="text/css" />
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">

    @php
        $favicon = App\Models\Preference::getFavicon();
    @endphp

    @if (!empty($favicon))
        <link rel='shortcut icon' href="{{ $favicon }}" type='image/x-icon' />
    @endif

    <!--Custom CSS that was written on view-->
    @doAction("before_site_css_{$view_name}")

    @yield('parent-css')

    @doAction("after_site_css_{$view_name}")
    <!-- Menubar css -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/ionicon.min.css') }}" />
    <!-- Menubar css end-->

    <!-- Custom CSS-->
    <link rel="stylesheet" href="{{ asset('public/dist/css/site_custom.min.css?v=2.8') }}">

    <!-- User define custom dynamic css file -->
    @if (File::exists('Modules/CMS/Resources/assets/css/user-custom.css'))
        <link rel="stylesheet" href="{{ asset('Modules/CMS/Resources/assets/css/user-custom.css?v=' . time()) }}">
    @endif


    
    @if (file_exists(base_path('public/js/lang/' . config('app.locale') . '.js')))
        <script src="{{ asset('public/js/lang/' . config('app.locale') . '.js') }}"></script>
    @else
        <script type="text/javascript">
            const translates = {};
        </script>
    @endif
    <script type="text/javascript">
        'use strict';
        var SITE_URL =  "{{ url(app()->getLocale()) }}";
        var currencySymbol = '{!! currency()->symbol !!}';
        var decimal_digits = '{!! preference('decimal_digits') !!}';
        var thousand_separator = '{!! preference('thousand_separator') !!}';
        var symbol_position = '{!! preference('symbol_position') !!}';
        var dateFormat = '{!! preference('date_format_type') !!}';
        var token = '{!! csrf_token() !!}';
        var app_locale_url = "{!! url('/resources/lang/' . config('app.locale') . '.json') !!}";
        var row_per_page = '{!! preference('row_per_page') !!}';
        var language_direction = '{!! languageDirection() !!}';
        var totalProductPerPage = '{!! totalProductPerPage() !!}';
        var variationId = null;
        var variationStatus = 'Out Of Stock';
        var itemType = '{{ \App\Enums\ProductType::$Simple }}';
        var tempItemType = '{{ \App\Enums\ProductType::$Simple }}';
        var isManageStock = null;
        var stockQty = null;
        var variationAttributeIds = [];
        var backOrders = 0;
        var qtyArray = [];
        var isGroupProduct = false;
        var offerTimer = null;
        var offerTimerDetailsPage = null;
        var tempIsGroupProduct = false;
        var exchangeRate = 1;
        @auth
        var userLoggedIn = true;
        @else
            var userLoggedIn = false;
        @endauth
        var loadLoginModalUrl = '{{ url('load-login-modal') }}';
    </script>
    <!-- Required Js -->
    <script src="{{ asset('public/dist/js/jquery.min.js') }}"></script>
    <!-- Affiliate Code Common Header -->

    
    
    @doAction('before_site_head')

    <meta name="google-site-verification" content="p9KulfNqluiDeDGxC5DLHya46P_BNvD12TilaoFxm3I" />
</head>


<body <?php echo apply_filters('site_body_tag', 'class="antialiased min-h-screen"'); ?> x-data="{ 'layout': 'grid' }" x-cloak>

    @doAction('after_site_body')

    @php
        $header = option($layout . '_template_header', '');
        $footer = option($layout . '_template_footer', '');
        $isEnableProduct = option($layout . '_template_product', '');
        
        $themeOptions = $themeOption->keyBy('name');
        $headerLogo = $themeOptions[$layout . '_template_header_logo'] ?? null;
        $headerMobileLogo = $themeOptions[$layout . '_template_header_mobile_logo'] ?? null;
        $footerLogo = $themeOptions[$layout . '_template_footer_logo'] ?? null;
        $googlePlay = $themeOptions[$layout . '_template_google_play'] ?? null;
        $appStore = $themeOptions[$layout . '_template_app_store'] ?? null;
        $downloadGooglePlay = $themeOptions[$layout . '_template_download_google_play_logo'] ?? null;
        $downloadAppStore = $themeOptions[$layout . '_template_download_app_store_logo'] ?? null;
        $paymentMethods = $themeOptions[$layout . '_template_payment_methods'] ?? null;
        
        $categories = App\Models\Category::whereNull('parent_id')->whereNot('id', 1)->get();
    @endphp
    <!-- Top nav start -->
    @doAction('before_site_top_nav')
    
    <!-- Top nav end -->

    <!-- header section start -->
    @doAction('before_site_header')
    @include('site/layouts.includes.header')
    
    <!-- header section end -->

    <!-- Bottom nav section start-->
    @doAction('before_site_bottom_nav')
    
    
    @doAction('after_site_bottom_nav')
    <!-- Bottom nav section End-->

    <div class="main-body">
        <div class="page-wrapper">
            <!-- Main content -->
            @doAction('before_site_content')
            @doAction("before_site_content_{$view_name}")

            @yield('parent-content')

            @doAction('after_site_content')
            @doAction("after_site_content_{$view_name}")
            <!-- Main content end -->
        </div>
    </div>

   
    {{-- Modal --}}
    @guest
        <div class="login-block"></div>
    @endguest
    
    <!-- section footer start -->
    @doAction('before_site_footer')
    
    @include('landing.includes.footer')
    

    @doAction('after_site_footer')
    <!-- section footer end -->
    {{-- Item view modal --}}

    
    @if(request()->route()->getName() != 'site.checkOut')
    @include('../site/layouts.includes.product-view')
    @endif
   
    <script>
        var loginNeeded = "{!! session('loginRequired') ? 1 : 0 !!}";
    </script>
    <script src="{{ asset('public/dist/js/custom/site/formatting.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/swiper/swiper-bundle.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/alpine.min.js') }}" defer></script>
    <script src="{{ asset('public/dist/js/custom/site/drawer.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/script.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/cart.min.js?v=3.2.1') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/lang.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/site-nav.min.js?v=3.0') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/sweet-alert2.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/site.min.js?v=2.9.3') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/main.min.js?v=3.2.1') }}"></script>

    <script src="{{ asset('public/new-landing/script.js') }}" ></script>

    @doAction("before_site_js_{$view_name}")

    @yield('parent-js')

    @doAction("after_site_js_{$view_name}")

    <!-- User define custom dynamic js file -->
    @if (File::exists('Modules/CMS/Resources/assets/js/user-custom.js'))
        <script async src="{{ asset('Modules/CMS/Resources/assets/js/user-custom.js?v=' . time()) }}"></script>
    @endif

    @doAction('before_site_body')
</body>

</html>
