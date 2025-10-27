 <!-- Header Section -->
 <header class="sticky top-0 z-50 w-full border-b border-gray-200 bg-white/95 backdrop-blur-sm">
    <div class="container max-w-6xl mx-auto px-4">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('site.index') }}" class="flex items-center">
                    <img src="{{ asset('public/new-landing/img/image 1.svg') }}" alt="Exports Valley" class="h-10 md:h-12">
                </a>
            </div>

            <!-- Navigation - Hidden on mobile -->
            <nav class="hidden md:flex items-center gap-6 rtl:space-x-reverse">
                <a 
                href="{{ route('site.categories') }}" 
                class="text-lg font-medium text-gray-900 opacity-80 hover:opacity-100 transition relative after:content-[''] after:absolute after:bottom-[-0.25rem] after:left-0 after:w-0 after:h-0.5 after:bg-orange-600 after:transition-all hover:after:w-full rtl:after:left-auto rtl:after:right-0">
                    @lang('Categories')
                </a>

                <a 
                href="{{ route('site.shop.index') }}" 
                class="text-lg font-medium text-gray-900 opacity-80 hover:opacity-100 transition relative after:content-[''] after:absolute after:bottom-[-0.25rem] after:left-0 after:w-0 after:h-0.5 after:bg-orange-600 after:transition-all hover:after:w-full rtl:after:left-auto rtl:after:right-0">
                    @lang('Factories')
                </a>

                <a 
                href="{{ route('site.quotations.create') }}" 
                class="text-lg font-medium text-gray-900 opacity-80 hover:opacity-100 transition relative after:content-[''] after:absolute after:bottom-[-0.25rem] after:left-0 after:w-0 after:h-0.5 after:bg-orange-600 after:transition-all hover:after:w-full rtl:after:left-auto rtl:after:right-0">
                    @lang('RFQs')
                </a>

                <a 
                href="{{ route('site.about-us') }}" 
                class="text-lg font-medium text-gray-900 opacity-80 hover:opacity-100 transition relative after:content-[''] after:absolute after:bottom-[-0.25rem] after:left-0 after:w-0 after:h-0.5 after:bg-orange-600 after:transition-all hover:after:w-full rtl:after:left-auto rtl:after:right-0">
                    @lang('About Us')
                </a>

            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3 rtl:space-x-reverse">
                
                @guest
                    <a 
                        href="{{ route('login') }}"
                        class="hidden md:flex gap-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white border-none rounded-full py-2 px-6 text-sm font-medium shadow-lg transition hover:from-orange-700 hover:to-orange-600 hover:shadow-xl items-center">
                        <span>
                            @lang('Login')
                        </span>

                        @if (languageDirection() == 'ltr')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        @endif
                    </a>
                @endguest

                @auth
                    <div class="relative">
                        <button id="account-dropdown-button" class="hidden md:flex gap-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white border-none rounded-full py-2 px-6 text-sm font-medium shadow-lg transition hover:from-orange-700 hover:to-orange-600 hover:shadow-xl items-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>@lang('My Account')</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <!-- Account Dropdown Menu -->
                        <div id="account-dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden transition-all duration-200 opacity-0 transform -translate-y-2">
                            <a href="{{ route('site.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                <svg class="w-4 h-4 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                @lang('My Account')
                            </a>
                            <a href="{{ route('site.logout') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                <svg class="w-4 h-4 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                @lang('Logout')
                            </a>
                        </div>
                    </div>
                @endauth

                <!-- Language Dropdown -->
                @php
                    $languages  = \App\Models\Language::getAll()->where('status', 'Active');
                    $currentLocale = app()->getLocale();
                    $currentLanguage = $languages->where('short_name', $currentLocale)->first();
                @endphp

                <div class="relative">

                    <button id="language-dropdown-button" class="lang-btn flex gap-2 bg-transparent text-gray-900 border-none rounded-md py-2 px-3 text-sm font-medium transition hover:bg-gray-100 items-center rtl:space-x-reverse">
                        <img style="width:16px; height:16px" class="self-center rounded-full mx-1" src='{{ url("public/datta-able/fonts/flag/flags/4x3/" . getSVGFlag($currentLanguage->short_name) . ".svg") }}' alt="{{ $currentLanguage->flag }}">
                        <span class="lang-text text-sm">
                            {{ $currentLanguage->name }}
                        </span>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="language-dropdown-menu" class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-1 z-50 hidden transition-all duration-200 opacity-0 transform -translate-y-2">
                        @foreach ($languages as $language)
                            <button 
                            onclick="window.location.href = '{{ LaravelLocalization::getLocalizedURL($language->short_name, null, [], true) }}'"
                            class="lang-option flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition" data-lang="{{ $language->short_name }}" data-flag="{{ $language->flag }}">
                                <img style="width:16px; height:16px" class="self-center rounded-full mx-1" src='{{ url("public/datta-able/fonts/flag/flags/4x3/" . getSVGFlag($language->short_name) . ".svg") }}' alt="{{ $language->flag }}">
                                <span class="lang-text mx-2">{{ $language->name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                
                <button class="md:hidden bg-transparent text-gray-900 border-none rounded-md p-2 transition hover:bg-gray-100 mobile-menu-btn">
                    <svg class="w-5 h-5 menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu - Hidden by default -->
        <div class="hidden mobile-menu fixed top-16 left-0 right-0 bottom-0 h-[calc(100vh-4rem)] z-49 overflow-y-auto bg-white border-t border-gray-200 flex flex-col justify-between">
            <nav class="flex flex-col gap-6 p-8">
                <a href="#categories" class="mobile-nav-link text-lg font-medium text-gray-900 opacity-80 hover:opacity-100 transition py-3 text-right rtl:text-right">Categories</a>
                <a href="#factories" class="mobile-nav-link text-lg font-medium text-gray-900 opacity-80 hover:opacity-100 transition py-3 text-right rtl:text-right">Factories</a>
                <a href="#quotes" class="mobile-nav-link text-lg font-medium text-gray-900 opacity-80 hover:opacity-100 transition py-3 text-right rtl:text-right">Quote Requests</a>
                <a href="#contact" class="mobile-nav-link text-lg font-medium text-gray-900 opacity-80 hover:opacity-100 transition py-3 text-right rtl:text-right">Contact Us</a>
            </nav>
            
            <div class="flex flex-col gap-3 p-6 border-t border-gray-200 bg-white">
                <button class="mobile-sign-in-btn w-full gap-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white border-none rounded-full py-3 px-6 text-base font-medium shadow-lg transition hover:from-orange-700 hover:to-orange-600 hover:shadow-xl flex items-center justify-center">
                    <span>Sign In</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <button class="mobile-contact-btn w-full gap-2 border-2 border-gray-200 bg-transparent text-gray-900 rounded-full py-3 px-6 text-base font-medium transition hover:bg-gray-100 flex items-center justify-center">
                    <span>Contact Us</span>
                    <img src="{{ asset('public/new-landing/img/material-symbols_arrow-insert-rounded.svg') }}" >
                </button>
            </div>
        </div>
    </div>
</header>


@push('styles')
    <style>
            
        .hero-img, .industry-img {
            transition: opacity 1s;
        }
        
        .hero-img.active, .industry-img.active {
            opacity: 1;
        }
        
        .mobile-menu {
            transition: all 0.3s ease;
        }
        
        .faq-answer {
            transition: all 0.3s ease;
        }
        
        .blob {
            animation: blob 7s infinite;
        }
        
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }
        
        .service-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .btn-icon-img {
            transform: rotate(90deg);
        }
        
        [dir="rtl"] .btn-icon-img {
            transform: rotate(0deg);
        }

        
        [dir="rtl"] .service-icon {
            right: 1.5rem;
            left: auto;
        }

        
        [dir="rtl"] .service-title,
        [dir="rtl"] .service-description {
            text-align: right;
        }

        [dir="rtl"] .hero-text,
        [dir="rtl"] .industry-text,
        [dir="rtl"] .vision-text {
            text-align: right;
        }

        [dir="rtl"] .faq-title,
        [dir="rtl"] .faq-question span,
        [dir="rtl"] .faq-answer p {
            text-align: right;
        }

        /* Account dropdown styles */
        #account-dropdown-menu {
            transition: all 0.2s ease-in-out;
        }
        
        #account-dropdown-menu.hidden {
            display: none !important;
        }
        
        #account-dropdown-menu:not(.hidden) {
            display: block;
        }
        
        #account-dropdown-menu.opacity-0 {
            opacity: 0;
        }
        
        #account-dropdown-menu.opacity-100 {
            opacity: 1;
        }
        
        #account-dropdown-menu.-translate-y-2 {
            transform: translateY(-0.5rem);
        }
        
        #account-dropdown-menu.translate-y-0 {
            transform: translateY(0);
        }

    </style> 
@endpush
