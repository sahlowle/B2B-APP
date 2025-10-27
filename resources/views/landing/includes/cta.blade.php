    <!-- CTA Section -->
    <section class="cta py-32 bg-white">
        <div class="mx-2">
            <div class="cta-content bg-[#063B7D] rounded-2xl p-12 md:p-16 text-center">
                <h2 class="cta-title text-2xl md:text-4xl font-bold text-white mb-6">
                    @lang('Request Price Quotes Without Registration')
                </h2>
                <p class="cta-description text-base md:text-lg text-blue-100 mb-10 max-w-3xl mx-auto leading-relaxed">
                    @lang('Get the best offers from trusted manufacturers through our network of specialists. Request quotes easily and compare prices to ensure competitive prices and quality services.')
                </p>
                <button 
                    onclick="window.location.href = '{{ route('site.quotations.create') }}'"
                     class="cta-button border-2 border-white bg-transparent text-white rounded-full py-4 px-8 md:py-5 md:px-10 text-lg md:text-xl font-medium transition hover:bg-white hover:text-[#063B7D] flex items-center justify-center gap-3 mx-auto group">
                    <span>@lang('Request a Quote')</span>
                    <img src="{{ asset('public/new-landing/img/material-symbols_arrow-insert-rounded.svg') }}" alt="Request Quote" class="w-6 h-6 filter invert brightness-0 group-hover:filter-none transition-all duration-300 ltr:rotate-90">
                </button>
            </div>
        </div>
    </section>
