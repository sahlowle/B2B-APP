    <!-- Services Section -->
    <section class="services py-20 bg-white">
        <div class="container max-w-6xl mx-auto px-4">
            <div class="services-header text-center mb-16">
                <h2 class="section-title text-3xl md:text-4xl font-bold text-orange-600 mb-4">
                    @lang('Our Services')
                </h2>
                <p class="section-description text-lg text-gray-600 max-w-3xl mx-auto">
                    @lang('We provide comprehensive solutions for Saudi factories and importers')
                </p>
            </div>
            
            <div class="services-section mb-20">
                <div class="service-type-header text-center mb-12">
                    <h3 class="service-type-title text-2xl font-bold text-gray-900 mb-3">
                        @lang('Factories Services')
                    </h3>
                    <p class="service-type-description text-gray-600 max-w-3xl mx-auto">
                        @lang('Smart solutions to help Saudi factories display their products and connect directly with importers around the world.')
                    </p>
                </div>

                <div class="services-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Service Cards for Factories -->
                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#F1592A] hover:border-[#F1592A] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <img src="{{ asset('public/new-landing/img/services/factories/01.svg') }}" alt="@lang('E-Store')" class="w-10 h-10">
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('E-Store')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Create an electronic store to display your products and manage your store easily.')
                        </p>
                    </div>
                    
                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#F1592A] hover:border-[#F1592A] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <img src="{{ asset('public/new-landing/img/services/factories/02.svg') }}" alt="@lang('Product Catalog Inquiry')" class="w-10 h-10">
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('Product Catalog Inquiry')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Inquire about and organize product catalogs with an easy and secure method.')
                        </p>
                    </div>
                    
                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#F1592A] hover:border-[#F1592A] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <img src="{{ asset('public/new-landing/img/services/factories/03.svg') }}" alt="@lang('Direct Contact with Importers')" class="w-10 h-10">
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('Direct Contact with Importers')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Direct communication channels with importers to facilitate negotiations and complete transactions.')
                        </p>
                    </div>
                    
                    
                    
                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#F1592A] hover:border-[#F1592A] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <img src="{{ asset('public/new-landing/img/services/factories/04.svg') }}" alt="@lang('Display Products for Each Platform Visitor')" class="w-10 h-10">
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('Display Products for Each Platform Visitor')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Wide access and display of your products to all platform visitors to increase commercial opportunities.')
                        </p>
                    </div>
                    
                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#F1592A] hover:border-[#F1592A] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <img src="{{ asset('public/new-landing/img/services/factories/05.svg') }}" alt="@lang('Integrated Logistics Services')" class="w-10 h-10">
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('Integrated Logistics Services')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Complete solutions for inspection, shipment, and delivery of your products safely and quickly.')
                        </p>
                    </div>

                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#F1592A] hover:border-[#F1592A] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <img src="{{ asset('public/new-landing/img/services/factories/06.svg') }}" alt="@lang('Factory Certification')" class="w-10 h-10">
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('Factory Certification')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Obtain factory certification to enhance customer confidence in your products and services.')
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="services-section">
                <div class="service-type-header text-center mb-12">
                    <h3 class="service-type-title text-2xl font-bold text-gray-900 mb-3">
                        @lang('Importers Services')
                    </h3>
                    <p class="service-type-description text-gray-600 max-w-3xl mx-auto">
                        @lang('Discover thousands of trusted factories and connect with them easily through our platform and one source for all your needs.')
                    </p>
                </div>

                <div class="services-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Service Cards for Importers -->          
                    
                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#182031] hover:border-[#182031] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" fill="#F4A89F" class="group-hover:fill-[#182031]"/>
                                <circle cx="12" cy="12" r="3" fill="#FF6B4A" class="group-hover:fill-[#182031]"/>
                            </svg>
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('Direct Contact with Factories')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Direct communication channels with factories to facilitate negotiations and complete transactions.')
                        </p>
                    </div>

                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#182031] hover:border-[#182031] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                                <rect x="4" y="3" width="16" height="14" rx="2" fill="#F4A89F" class="group-hover:fill-[#182031]"/>
                                <path d="M4 10h16" stroke="#FF6B4A" stroke-width="1.5" class="group-hover:stroke-[#182031]"/>
                                <path d="M4 14h16" stroke="#FF6B4A" stroke-width="1.5" class="group-hover:stroke-[#182031]"/>
                            </svg>
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('Price Quote Request Without Registration')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Get price quotes from factories without the need to register on the platform.')
                        </p>
                    </div>
                    
                   

                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#182031] hover:border-[#182031] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                                <rect x="5" y="8" width="14" height="10" rx="2" fill="#F4A89F" class="group-hover:fill-[#182031]"/>
                                <path d="M9 8V6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2" stroke="#FF6B4A" stroke-width="2" fill="none" class="group-hover:stroke-[#182031]"/>
                                <circle cx="8" cy="16" r="1.5" fill="#FF6B4A" class="group-hover:fill-[#182031]"/>
                                <circle cx="16" cy="16" r="1.5" fill="#FF6B4A" class="group-hover:fill-[#182031]"/>
                            </svg>
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('Factory Comparison')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Advanced comparison tools for factories and prices to make informed purchasing decisions.')
                        </p>
                    </div>

                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#182031] hover:border-[#182031] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                                <rect x="3" y="3" width="18" height="14" rx="2" fill="#F4A89F" class="group-hover:fill-[#182031]"/>
                                <path d="M8 17h8M10 21h4" stroke="#FF6B4A" stroke-width="1.5" stroke-linecap="round" class="group-hover:stroke-[#182031]"/>
                            </svg>
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('Pre-Shipment Inspection')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Inspection and verification service before shipment to ensure quality and specifications.')
                        </p>
                    </div>
                    
                    <div class="service-card bg-white border border-gray-200 rounded-2xl p-8 pt-16 transition-all duration-300 min-h-64 flex flex-col justify-center items-center relative hover:bg-[#182031] hover:border-[#182031] group">
                        <div class="service-icon absolute top-6 left-6 w-10 h-10 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center group-hover:bg-white group-hover:border-white">
                            <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                                <path d="M12 2L15.09 8.26H22L17.55 12.5L19.64 18.76L12 14.51L4.36 18.76L6.45 12.5L2 8.26H8.91L12 2Z" fill="#F4A89F" class="group-hover:fill-[#182031]"/>
                                <path d="M12 5L13.5 8.5H17L14.25 10.5L15.75 14L12 12L8.25 14L9.75 10.5L7 8.5H10.5L12 5Z" fill="#FF6B4A" class="group-hover:fill-[#182031]"/>
                            </svg>
                        </div>
                        <h4 class="service-title text-xl font-bold mb-3 w-full text-left group-hover:text-white">
                            @lang('Certified Saudi Factories')
                        </h4>
                        <p class="service-description text-sm text-gray-600 leading-relaxed w-full text-left group-hover:text-white">
                            @lang('Deal with certified Saudi factories with guaranteed quality and quality assurance for your peace of mind.')
                        </p>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </section>
