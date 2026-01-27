@extends('site.layouts.app')


@push('styles')
    <style>
        .animate-fade-in-down { animation: fadeInDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }
        
        /* Smooth Rotate for Icon */
        details[open] summary .group-open\:rotate-180 { transform: rotate(180deg); }

        @keyframes fadeInDown { to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    </style>
@endpush

<x-seo :seo="$seo" />

@section('content')
    <div class="mt-8">
            <nav class="text-gray-600 text-sm" aria-label="Breadcrumb">
                <ol
                    class="list-none p-0 flex flex-wrap md:inline-flex text-xs md:text-sm roboto-medium font-medium text-gray-10 leading-5">
                    <li class="flex items-center">
                        <svg class="-mt-1 ltr:mr-2 rtl:ml-2" width="13"
                            height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.35643 1.89407C4.93608 2.1717 4.43485 2.59943 3.69438 3.23412L2.916 3.9013C2.0595 4.63545 1.82512 4.85827 1.69934 5.13174C1.57357 5.4052 1.55692 5.72817 1.55692 6.85625V10.1569C1.55692 10.9127 1.55857 11.4013 1.60698 11.7613C1.65237 12.099 1.72565 12.2048 1.7849 12.264C1.84416 12.3233 1.94997 12.3966 2.28759 12.442C2.64759 12.4904 3.13619 12.492 3.89206 12.492H8.56233C9.31819 12.492 9.80679 12.4904 10.1668 12.442C10.5044 12.3966 10.6102 12.3233 10.6695 12.264C10.7287 12.2048 10.802 12.099 10.8474 11.7613C10.8958 11.4013 10.8975 10.9127 10.8975 10.1569V6.85625C10.8975 5.72817 10.8808 5.4052 10.755 5.13174C10.6293 4.85827 10.3949 4.63545 9.53838 3.9013L8.76 3.23412C8.01953 2.59943 7.5183 2.1717 7.09795 1.89407C6.69581 1.62848 6.44872 1.55676 6.22719 1.55676C6.00566 1.55676 5.75857 1.62848 5.35643 1.89407ZM4.49849 0.595063C5.03749 0.239073 5.5849 0 6.22719 0C6.86948 0 7.41689 0.239073 7.95589 0.595063C8.4674 0.932894 9.04235 1.42573 9.7353 2.01972L10.5515 2.71933C10.5892 2.75162 10.6264 2.78347 10.6632 2.81492C11.3564 3.40806 11.8831 3.85873 12.1694 4.48124C12.4557 5.10375 12.4551 5.79693 12.4543 6.70926C12.4543 6.75764 12.4542 6.80662 12.4542 6.85625L12.4542 10.2081C12.4543 10.8981 12.4543 11.4927 12.3903 11.9688C12.3217 12.479 12.167 12.9681 11.7703 13.3648C11.3736 13.7615 10.8845 13.9162 10.3742 13.9848C9.89812 14.0488 9.30358 14.0488 8.61355 14.0488H3.84083C3.1508 14.0488 2.55626 14.0488 2.08015 13.9848C1.56991 13.9162 1.08082 13.7615 0.68411 13.3648C0.2874 12.9681 0.132701 12.479 0.064101 11.9688C9.07021e-05 11.4927 0.000124017 10.8981 0.000162803 10.2081L0.000164659 6.85625C0.000164659 6.80662 0.000122439 6.75763 8.07765e-05 6.70926C-0.000705247 5.79693 -0.00130245 5.10374 0.285011 4.48124C0.571324 3.85873 1.09802 3.40806 1.79122 2.81492C1.82798 2.78347 1.8652 2.75162 1.90288 2.71933L2.68126 2.05215all_categories.bladeC2.69391 2.0413 2.70652 2.03049 2.71909 2.01972C3.41204 1.42573 3.98698 0.932893 4.49849 0.595063Z"
                                fill="#898989"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.50293 9.37853C3.50293 8.51876 4.19991 7.82178 5.05969 7.82178H7.39482C8.25459 7.82178 8.95158 8.51876 8.95158 9.37853V13.2704C8.95158 13.7003 8.60309 14.0488 8.1732 14.0488C7.74331 14.0488 7.39482 13.7003 7.39482 13.2704V9.37853H5.05969V13.2704C5.05969 13.7003 4.71119 14.0488 4.28131 14.0488C3.85142 14.0488 3.50293 13.7003 3.50293 13.2704V9.37853Z"
                                fill="#898989"></path>
                        </svg>
                        <a href="{{ route('site.index') }}">{{ __('Home') }}</a>
                        <p class="px-2 text-gray-12">/</p>
                    </li>
                    <li class="flex items-center text-gray-12">
                        <a href="javascript: void(0)">{{ __('Frequently Asked Questions') }}</a>
                    </li>
                </ol>
            </nav>
    </div>
        
    {{-- 2. FAQ List --}}
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            
            @if($faqs->count() > 0)
                <div class="space-y-4" id="faqs-list">
                    @foreach($faqs as $faq)
                        <div class="faq-item group bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 overflow-hidden">
                            <details class="w-full">
                                <summary class="flex items-center justify-between p-6 cursor-pointer list-none select-none">
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-orange-600 transition-colors pr-8">
                                        {{ $faq->question }}
                                    </h3>
                                    <div class="flex-shrink-0 ml-4">
                                        <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 transition-transform duration-300 group-open:rotate-180">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </summary>
                                <div class="px-6 pb-6 pt-2 text-gray-600 leading-relaxed border-t border-gray-50/50">
                                    <div class="prose prose-orange max-w-none">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </details>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-full shadow-lg border border-gray-100 px-6 py-2">
                        {{ $faqs->links() }}
                    </div>
                </div>

            @else
                {{-- Empty State --}}
                <div class="text-center py-20">
                    <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ trans('No questions found') }}</h3>
                </div>
            @endif
            
            {{-- No Results Message (Hidden by default) --}}
            <div id="no-results" class="hidden text-center py-20">
                 <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ trans('No matching questions found') }}</h3>
                <p class="text-gray-500 mb-6">{{ trans('Try adjusting your search terms.') }}</p>
                <button onclick="document.getElementById('faq-search').value = ''; document.getElementById('faq-search').dispatchEvent(new Event('input'));" 
                        class="px-6 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:border-orange-500 hover:text-orange-600 transition-colors">
                    {{ trans('Clear Search') }}
                </button>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Search Functionality
                const searchInput = document.getElementById('faq-search');
                const faqsList = document.getElementById('faqs-list');
                const noResults = document.getElementById('no-results');
                
                if (searchInput && faqsList) {
                    searchInput.addEventListener('input', function(e) {
                        const searchTerm = e.target.value.toLowerCase();
                        const faqItems = faqsList.querySelectorAll('.faq-item');
                        let visibleCount = 0;
                        
                        faqItems.forEach(item => {
                            const question = item.querySelector('button span').textContent.toLowerCase();
                            const answer = item.querySelector('.prose').textContent.toLowerCase();
                            
                            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                                item.style.display = '';
                                visibleCount++;
                            } else {
                                item.style.display = 'none';
                            }
                        });

                        if (visibleCount === 0) {
                            faqsList.classList.add('hidden');
                            noResults.classList.remove('hidden');
                        } else {
                            faqsList.classList.remove('hidden');
                            noResults.classList.add('hidden');
                        }
                    });
                }

                // Accordion Functionality
                const faqToggles = document.querySelectorAll('.faq-toggle');

                faqToggles.forEach(toggle => {
                    toggle.addEventListener('click', function() {
                        const content = this.nextElementSibling;
                        const icon = this.querySelector('svg');
                        
                        // Toggle current
                        content.classList.toggle('hidden');
                        icon.classList.toggle('rotate-180');
                        
                        // Optional: Close others? 
                        // To behave like independent cards, we don't need to close others.
                        // If accordion behavior (only one open) is desired, uncomment below:
                        /*
                        faqToggles.forEach(otherToggle => {
                            if (otherToggle !== toggle) {
                                otherToggle.nextElementSibling.classList.add('hidden');
                                otherToggle.querySelector('svg').classList.remove('rotate-180');
                            }
                        });
                        */
                    });
                });
            });
        </script>
    @endsection

@endsection