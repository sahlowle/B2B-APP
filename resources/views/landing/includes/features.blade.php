    <!-- Features Section -->
    <section class="features py-20 md:py-32 bg-white">
        <div class="container max-w-6xl mx-auto px-4">
            <div class="features-content flex flex-col md:flex-row md:items-center gap-12">
                <div class="features-text w-full md:w-5/12">
                    <h2 class="section-title text-3xl md:text-4xl font-bold text-orange-600 mb-6">
                        @lang('Start Your Business Journey Today')
                    </h2>
                    <p class="section-description text-lg text-gray-600 leading-relaxed">
                        @lang('Join thousands of factories and importers who trust our platform and benefit from the best technical solutions in the market.')
                    </p>
                </div>
                <div class="features-grid w-full md:w-7/12" dir="{{ languageDirection() == 'rtl' ? 'ltr' : 'rtl' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Feature Card 1 -->
                        <div class="feature-card bg-white border border-gray-200 rounded-2xl p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-orange-300 relative overflow-hidden text-center">
                            <div class="feature-icon w-16 h-16 rounded-xl flex items-center justify-center mb-6 transition-transform duration-300 mx-auto">
                                <img src="{{ asset('public/new-landing/img/features/02.svg') }}" alt="@lang('Trusted Security')" class="w-16 h-16">
                            </div>
                            <h3 class="feature-title text-xl font-bold mb-3">
                                @lang('Trusted Security')
                            </h3>
                            <p class="feature-description text-gray-600 leading-relaxed">
                                @lang('Comprehensive protection for all transactions')
                            </p>
                        </div>

                        <!-- Feature Card 2 -->
                        <div class="feature-card offset-top bg-white border border-gray-200 rounded-2xl p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-orange-300 relative overflow-hidden text-center md:translate-y-8">
                            <div class="feature-icon w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 shadow-lg transition-transform duration-300 mx-auto">
                                <img src="{{ asset('public/new-landing/img/features/01.svg') }}" alt="@lang('Global Reach')" class="w-16 h-16">
                            </div>
                            <h3 class="feature-title text-xl font-bold mb-3">
                                @lang('Global Reach')
                            </h3>
                            <p class="feature-description text-gray-600 leading-relaxed">
                                @lang('A shipping network that reaches all parts of the world')
                            </p>
                        </div>

                        <!-- Feature Card 3 -->
                        <div class="feature-card bg-white border border-gray-200 rounded-2xl p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-orange-300 relative overflow-hidden text-center">
                            <div class="feature-icon w-16 h-16 rounded-xl flex items-center justify-center mb-6 shadow-lg transition-transform duration-300 mx-auto">
                               <img src="{{ asset('public/new-landing/img/features/03.svg') }}" alt="@lang('High Efficiency')" class="w-16 h-16">
                            </div>
                            <h3 class="feature-title text-xl font-bold mb-3">
                                @lang('High Efficiency')
                            </h3>
                            <p class="feature-description text-gray-600 leading-relaxed">
                                @lang('Accurate and fast operations in record time')
                            </p>
                        </div>

                        <!-- Feature Card 4 -->
                        <div class="feature-card offset-top bg-white border border-gray-200 rounded-2xl p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-orange-300 relative overflow-hidden text-center md:translate-y-8">
                            <div class="feature-icon w-16 h-16 rounded-xl flex items-center justify-center mb-6 transition-transform duration-300 mx-auto">
                                <img src="{{ asset('public/new-landing/img/features/04.svg') }}" alt="@lang('Continuous Support')" class="w-16 h-16">
                            </div>
                            <h3 class="feature-title text-xl font-bold mb-3">
                                @lang('Continuous Support')
                            </h3>
                            <p class="feature-description text-gray-600 leading-relaxed">
                                @lang('Customer service available around the clock')
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
