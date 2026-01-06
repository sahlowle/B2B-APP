<section class="hero relative overflow-hidden bg-gradient-to-b from-white to-gray-100 py-20 md:py-32">
    <div class="hero-background absolute top-0 left-0 right-0 bottom-0 overflow-hidden z-0">
        <div class="blob blob-1 absolute top-20 right-10 w-72 h-72 bg-orange-200 mix-blend-multiply filter blur-3xl opacity-20 rounded-full"></div>
        <div class="blob blob-2 absolute bottom-20 left-10 w-72 h-72 bg-orange-300 mix-blend-multiply filter blur-3xl opacity-20 rounded-full"></div>
    </div>
    <div class="container max-w-6xl mx-auto px-4">
        <div class="hero-content flex flex-col md:flex-row items-center gap-12 relative z-10">
            <div class="hero-image w-full md:w-1/2 md:order-1">
                <div class="image-container relative aspect-square max-w-lg mx-auto">
                    <img 
                        src="{{ asset('public/new-landing/img/hero.webp') }}" 
                        alt="Shipping Containers" 
                        style="width: 100%; height: 100%;"
                        class="hero-img absolute inset-0  rounded-2xl shadow-2xl bg-gradient-to-br from-orange-400 to-orange-600">
                </div>
            </div>
            <div class="hero-text w-full md:w-1/2">
                <h1 class="hero-title text-4xl md:text-5xl font-bold mb-6 text-orange-600">
                    @lang('Exports Valley')
                </h1>

                <p class="hero-description text-lg text-gray-600 mb-8 leading-relaxed">
                    @lang('A comprehensive platform connecting Saudi factories with importers worldwide. We provide a safe and integrated environment for international trade, offering digital solutions backed by artificial intelligence to simplify communication, negotiation, and agreement processes.')
                </p>

                <div class="hero-buttons flex flex-row flex-wrap gap-3 md:gap-4 justify-center md:justify-start">
                    <a 
                        href="{{ route('registration') }}"
                        class="btn-primary bg-gradient-to-r from-orange-600 to-orange-500 text-white border-none rounded-full py-3 px-6 md:py-4 md:px-8 text-base md:text-lg font-medium shadow-lg transition hover:from-orange-700 hover:to-orange-600 hover:shadow-xl flex items-center justify-center gap-2 flex-1 min-w-[140px] max-w-[200px]">
                        <span>
                            @lang('Register Now')
                        </span>
                        <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a 
                        href="{{ route('site.contact-us') }}"
                        class="btn-secondary border-2 border-gray-200 bg-transparent text-gray-900 rounded-full py-3 px-6 md:py-4 md:px-8 text-base md:text-lg font-medium transition hover:bg-gray-100 flex items-center justify-center gap-2 flex-1 min-w-[140px] max-w-[200px]">
                        <span>
                            @lang('Contact Us')
                        </span>
                        <img src="{{ asset('public/new-landing/img/material-symbols_arrow-insert-rounded.svg') }}" alt="Contact Us" class="w-4 h-4 btn-icon-img rtl:rotate-180">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
