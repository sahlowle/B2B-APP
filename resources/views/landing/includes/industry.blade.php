    <!-- Saudi Industry Section -->
    <section class="saudi-industry py-20 bg-white">
        <div class="container max-w-6xl mx-auto px-4">
            <div class="industry-content flex flex-col md:flex-row items-center gap-12 mb-20">
                <div class="industry-image w-full md:w-1/2">
                    <div class="image-container relative aspect-square max-w-lg mx-auto">
                        <img src="{{ asset("public/new-landing/img/discover-1.jpg ")}}" alt="Saudi Factory" class="industry-img active absolute inset-0 w-full h-full object-cover rounded-2xl shadow-2xl">
                        <img src="{{ asset("public/new-landing/img/discover-2.jpg ")}}"alt="Saudi Warehouse" class="industry-img absolute inset-0 w-full h-full object-cover rounded-2xl shadow-2xl">
                        <img src="{{ asset("public/new-landing/img/discover-3.jpg ")}}" alt="Saudi Products" class="industry-img absolute inset-0 w-full h-full object-cover rounded-2xl shadow-2xl">
                    </div>
                </div>
                <div class="industry-text w-full md:w-1/2 text-left">
                    <h2 class="section-title text-3xl md:text-4xl font-bold text-orange-600 mb-6">
                        @lang('Discover the Power of Saudi Industry')
                    </h2>

                    <p class="section-description text-lg text-gray-600 mb-8 leading-relaxed">
                        @lang('Browse high-quality products from trusted Saudi factories. Benefit from cooperation and distribution opportunities through our integrated platform.')
                    </p>

                    <button
                        onclick="window.location.href = '{{ route('site.productSearch') }}'"
                        class="btn-primary bg-gradient-to-r from-orange-600 to-orange-500 text-white border-none rounded-full py-3 px-6 text-base font-medium shadow-lg transition hover:from-orange-700 hover:to-orange-600 hover:shadow-xl flex items-center justify-center gap-2 group">
                        <span>@lang('Browse Products')</span>
                        <img src="{{ asset("public/new-landing/img/material-symbols_arrow-insert-rounded.svg") }}" alt="Browse Products" class="w-6 h-6 filter invert brightness-0 group-hover:filter-none transition-all duration-300 ltr:rotate-90 ">
                    </button>

                </div>
            </div>
            
            <div class="vision-content flex flex-col-reverse md:flex-row items-center gap-12">
                <div class="vision-text w-full md:w-1/2 text-left">
                    <h3 class="vision-title text-3xl font-bold text-orange-600 mb-6">
                        @lang("Towards Achieving Kingdom's Vision 2030")
                    </h3>
                    <p class="vision-description text-lg text-gray-600 leading-relaxed">
                        @lang("We contribute to empowering Saudi industry and promoting it globally through innovative digital solutions that support economic transformation and align with the Kingdom's Vision 2030 goals.")
                    </p>
                </div>
                <div class="vision-image w-full md:w-1/2 flex justify-center items-center min-h-[300px] md:min-h-[400px] bg-gray-50 rounded-2xl">
                    <img src="{{ asset("public/new-landing/img/Group.png") }}" alt="Vision 2030 Logo" class="vision-img w-48 md:w-64 object-contain rounded-2xl p-8 md:p-10">
                </div>
            </div>
        </div>
    </section>
