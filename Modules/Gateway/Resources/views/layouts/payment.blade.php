<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon icon -->
    @include('gateway::partial.favicon')
    <title>@yield('gateway') {{ __('Payment') }}</title>
    <link href="{{ asset('Modules/Gateway/Resources/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('Modules/Gateway/Resources/assets/css/gateway.min.css') }}">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css')
</head>

<body dir="{{ Session::get('language_direction') }}" >
    <section class="card-width card2">
        <div class="payment-loader">
            <div class="sp sp-circle"></div>
        </div>
        </div>
        
        <!-- Language Switcher -->
        <div class="position-absolute top-0 end-0 m-3">
            <div class="language-switcher">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe me-2"></i>
                        <span class="current-lang">{{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="#" onclick="switchLanguage('en')">
                                <i class="fas fa-flag-usa me-2"></i>English
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="#" onclick="switchLanguage('ar')">
                                <i class="fas fa-flag me-2"></i>العربية
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="svg-1">
            @include('gateway::partial.logo')
        </div>
        <div class="amount-gateway">
            <div>
                <p class="para-1">{{ __('Amount to be paid') }}</p>
                <p class="para-2">{{ formatNumber($purchaseData->total) }}</p>
            </div>
            <div>
                <p class="para-1 text-end">{{ __('GATEAWAY') }}</p>
                <img class="mt-2 gateway-logo" src="@yield('logo')" alt="{{ __('Image') }}" />
            </div>
        </div>
        @yield('content')
        <a href="#" onclick="history.back()" class="d-flex my-4 position-relative back">
            <svg class="arrow position-absolute" xmlns="http://www.w3.org/2000/svg" width="15" height="10"
                viewBox="0 0 15 10" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M4.70711 0L6.12132 1.41421L3.82843 3.70711H13.4142C13.9665 3.70711 14.4142 4.15482 14.4142 4.70711C14.4142 5.25939 13.9665 5.70711 13.4142 5.70711H3.82843L6.12132 8L4.70711 9.41421L0 4.70711L4.70711 0Z" fill="currentColor" />
            </svg>{{ __('Back') }}
        </a>
    </section>

    <script src="{{ asset('Modules/Gateway/Resources/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('Modules/Gateway/Resources/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Modules/Gateway/Resources/assets/js/app.min.js') }}"></script>
    
    <!-- Language Switcher Styles -->
    <style>
        .language-switcher {
            z-index: 1000;
        }
        
        .language-switcher .btn {
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 14px;
            min-width: 100px;
        }
        
        .language-switcher .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }
        
        .language-switcher .dropdown-item {
            padding: 8px 16px;
            font-size: 14px;
        }
        
        .language-switcher .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .language-switcher .dropdown-item.active {
            background-color: #007bff;
            color: white;
        }
        
        .language-switcher .dropdown-item.active:hover {
            background-color: #0056b3;
        }
    </style>
    
    <!-- Language Switcher JavaScript -->
    <script>
        function switchLanguage(lang) {
            
            $.ajax({
                url: '{{ route("change-language-admin") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    lang: lang,
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    </script>
    
    @yield('js')
</body>

</html>
