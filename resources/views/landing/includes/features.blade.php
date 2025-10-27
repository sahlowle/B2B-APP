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
                            <div class="feature-icon w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 shadow-lg transition-transform duration-300 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                                </svg>
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
                            <div class="feature-icon w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 shadow-lg transition-transform duration-300 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                </svg>
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
                            <div class="feature-icon w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 shadow-lg transition-transform duration-300 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
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
