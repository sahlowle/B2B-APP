@extends('site.layouts.app')

<x-seo :seo="$seo" />

@section('content')
    <section class="layout-wrapper px-4 xl:px-0">
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
                        <a href="javascript: void(0)">{{ __('All Categories') }}</a>
                    </li>
                </ol>
            </nav>
        </div>
        
         <!-- Categories Grid -->
         @if($categories->count() > 0)
         <div class="mt-8 mb-8">
             
             
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                 @foreach($categories as $category)
                 
                     <!-- Parent Category (collapsible) -->
                     <div class="group bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                         <!-- Collapsible Header -->
                         <div class="collapsible-header cursor-pointer p-5 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 hover:from-blue-100 hover:via-indigo-100 hover:to-purple-100 transition-all duration-300" 
                              role="button" 
                              tabindex="0"
                              aria-expanded="false"
                              aria-controls="category-{{ $category->id }}"
                              id="header-{{ $category->id }}">
                             <div class="flex items-start justify-between gap-3">
                                 <div class="flex-1 min-w-0">
                                     
                                     <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight group-hover:text-blue-600 transition-colors">
                                         {{ $category->name }}
                                     </h3>
                                     @if($category->availableMainCategory->count() > 0)
                                     <div class="flex items-center gap-1.5 text-sm text-gray-600">
                                         <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                         </svg>
                                         <span class="font-medium">{{ $category->availableMainCategory->count() }}</span>
                                         <span>{{ __('Sub Category') }}</span>
                                     </div>
                                     @else
                                     <div class="text-sm text-gray-500 italic">{{ __('No subcategories') }}</div>
                                     @endif
                                 </div>
                                 @if($category->availableMainCategory && $category->availableMainCategory->count() > 0)
                                 <div class="flex-shrink-0 mt-1">
                                     <svg class="w-6 h-6 text-blue-600 transition-transform duration-300 transform rotate-0" 
                                          fill="none" 
                                          stroke="currentColor" 
                                          viewBox="0 0 24 24"
                                          aria-hidden="true">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                     </svg>
                                 </div>
                                 @endif
                             </div>
                         </div>
                         
                         <!-- Collapsible Content -->
                         @if($category->availableMainCategory && $category->availableMainCategory->count() > 0)
                         <div class="collapsible-content border-t border-gray-100" 
                              id="category-{{ $category->id }}"
                              role="region"
                              aria-labelledby="header-{{ $category->id }}">
                             <div class="p-4 space-y-2 bg-gray-50">
                                 @foreach($category->availableMainCategory as $index => $childCategory)
                                 <a href="{{ route('site.productSearch', ['categories' => $childCategory->slug]) }}" 
                                    class="group/item block p-3.5 bg-white border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 hover:shadow-md transition-all duration-200 transform hover:translate-x-1">
                                     <div class="flex items-start justify-between gap-2">
                                         <div class="flex-1 min-w-0">
                                             <div class="flex items-center gap-2 mb-1">
                                                 <div class="w-1.5 h-1.5 rounded-full bg-blue-400 group-hover/item:bg-blue-600 transition-colors"></div>
                                                 <div class="text-sm font-semibold text-gray-800 group-hover/item:text-blue-700 transition-colors">
                                                     {{ $childCategory->name }}
                                                 </div>
                                             </div>
                                             @if($childCategory->code)
                                             <div class="text-xs text-gray-500 ml-3.5 group-hover/item:text-gray-600">
                                                 {{ $childCategory->code }}
                                             </div>
                                             @endif
                                         </div>
                                         <svg class="w-4 h-4 text-gray-400 group-hover/item:text-blue-600 opacity-0 group-hover/item:opacity-100 transition-all flex-shrink-0 mt-0.5" 
                                              fill="none" 
                                              stroke="currentColor" 
                                              viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                         </svg>
                                     </div>
                                 </a>
                                 @endforeach
                             </div>
                         </div>
                         @endif
                     </div>
                 
                 @endforeach
             </div>
             <div class="mt-4">
                 {{ $categories->links('pagination::tailwind') }}
             </div>
         </div>

       
         @else
         <div class="text-center py-16 px-4">
             <div class="max-w-md mx-auto">
                 <div class="relative">
                     <svg class="mx-auto h-20 w-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                     </svg>
                     <div class="absolute inset-0 flex items-center justify-center">
                         <div class="w-16 h-16 bg-gray-100 rounded-full opacity-50"></div>
                     </div>
                 </div>
                 <h3 class="mt-6 text-xl font-semibold text-gray-900">{{ __('No categories found') }}</h3>
                 <p class="mt-2 text-sm text-gray-500 max-w-sm mx-auto">
                     {{ __('We couldn\'t find any categories at the moment. Please check back later.') }}
                 </p>
             </div>
         </div>
         @endif
    </section>
@endsection

@section('js')
   <script>
        $(document).ready(function() {
            // Initially hide the content
            $('.collapsible-content').hide();

            // Add a click event to the header
            $('.collapsible-header').on('click', function(e) {
                e.preventDefault();
                const $header = $(this);
                const $content = $header.next('.collapsible-content');
                const $icon = $header.find('svg');
                const isExpanded = $header.attr('aria-expanded') === 'true';
                
                // Toggle the visibility of the content with smooth animation
                $content.slideToggle(300, function() {
                    // Update ARIA attributes
                    $header.attr('aria-expanded', !isExpanded);
                    
                    // Rotate the chevron icon (180 degrees for down arrow)
                    if (!isExpanded) {
                        $icon.css('transform', 'rotate(180deg)');
                    } else {
                        $icon.css('transform', 'rotate(0deg)');
                    }
                });
            });

            // Support keyboard navigation (Enter and Space)
            $('.collapsible-header').on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).trigger('click');
                }
            });

            // Add focus styles for better accessibility
            $('.collapsible-header').on('focus', function() {
                $(this).addClass('ring-2 ring-blue-500 ring-offset-2');
            }).on('blur', function() {
                $(this).removeClass('ring-2 ring-blue-500 ring-offset-2');
            });
        });
   </script>
@endsection
