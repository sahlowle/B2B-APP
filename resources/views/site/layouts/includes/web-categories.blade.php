@php
    $fixedMenu = isset($slides) && $slides->count() && isset($header['bottom']['category_expand']) && $header['bottom']['category_expand'] == 1;
    $uncategorized = App\Models\Category::parents();
    $categories = $uncategorized->where('id', '!=', 1);
@endphp
<div class="accordion-homepage-wrapper">
    <div class="overflow-hidden tran menu-full-details {{ count($categories) > 8 ? ' height-437p ' : '  ' }} ">
        @foreach ($categories as $category)
            @php $checkChildCategory =count($category->childrenCategories) @endphp
            <li class="border-b text-left text-gray-10 category-list-decoration">
                <button class="text-left outline-none focus:outline-none w-full">
                    <div class="primary-bg-hover">
                        <a class="title-font font-medium text-sm"
                            href="{{ route('site.productSearch', ['categories' => $category->slug]) }}">
                            <div
                                class="flex items-center justify-between w-full categories-menu h-12 ltr:pl-5 ltr:pr-4 rtl:pr-5 rtl:pl-4">
                                <div class="flex justify-center items-center">
                                    <div class="h-5 w-5">
                                        <img class="h-full" src="{{ $category->fileUrlQuery() }}" alt="{{ __('Image') }}">
                                    </div>
                                    <span
                                        class="text-sm cursor-pointer text-one ltr:pl-3 rtl:pr-3 rtl:text-right">
                                        {{ trimWords( $category->name, 25) }}
                                    </span>
                                </div>
                                @if ($checkChildCategory)
                                    <span class="neg-transition-scale">
                                        <svg class="fill-current h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                    </a>
                    </div>
                </button>
                @if ($checkChildCategory)
                    <ul
                        class="bg-white border absolute top-0 ul-mr min-h-full w-63 ltr:border-l-0 ltr:right-1p rtl:border-r-0 rtl:left-1p">
                        @foreach ($category->childrenCategories as $childCategory)
                            <li class="border-b text-gray-10 w-63 ltr:text-left rtl:text-right">
                                <button
                                    class="w-full category-hover flex items-center outline-none focus:outline-none ltr:text-left rtl:text-right">
                                    <div
                                        class="w-64 h-12 flex-shrink-0 md:mx-0 mx-auto text-center p-1 py-2 relative ltr:md:text-left rtl:md:text-right">
                                        <a href="{{ route('site.productSearch', ['categories' => $childCategory->slug]) }}"
                                            class="flex title-font font-medium items-center justify-center m-1 md:justify-start ltr:ml-2 rtl:mr-2">
                                            <span
                                                class="text-sm cursor-pointer text-one ltr:ml-3 rtl:mr-3">{{ trimWords( $childCategory->name, 30) }}</span>
                                            @if (count($childCategory->categories))
                                                <span
                                                    class="absolute top-0 text-center text-sm h-6 w-6 p-0.5 mt-3 ltr:-right-1 ltr:ml-3 rtl:-left-1 rtl:mr-3 neg-transition-scale">
                                                    <svg class="fill-current h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </a>
                                    </div>
                                </button>
                                @if ($childCategory->categories->count() > 0)
                                    <ul
                                        class="bg-white border pb-0.5 absolute top-0 ul-mr min-h-full w-63 ltr:right-0.5 rtl:left-0.5">
                                        @foreach ($childCategory->categories as $grandChildCategory)
                                            <li class="border-b text-gray-10 w-63 ltr:text-left rtl:text-right">
                                                <button
                                                    class="w-full category-hover flex items-center outline-none focus:outline-none ltr:text-left rtl:text-right">
                                                    <div
                                                        class="w-64 h-12 flex-shrink-0 md:mx-0 mx-auto text-center p-1 py-2 relative ltr:md:text-left rtl:md:text-right">
                                                        <a href="{{ route('site.productSearch', ['categories' => $grandChildCategory->slug]) }}"
                                                            class="flex title-font font-medium items-center justify-center m-1 md:justify-start ltr:ml-2 rtl:mr-2">
                                                            <span
                                                                class="text-sm cursor-pointer text-one ltr:ml-3 rtl:mr-3">
                                                                {{ trimWords( $grandChildCategory->name, 30) }}
                                                            </span>
                                                            @if (count($grandChildCategory->categories))
                                                                <span class="absolute top-0 text-center text-sm h-6 w-6 p-0.5 mt-3 ltr:-right-1 ltr:ml-3 rtl:-left-1 rtl:mr-3 neg-transition-scale">
                                                                    <svg class="fill-current h-4 w-4"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                                    </svg>
                                                                </span>
                                                            @endif
                                                        </a>
                                                    </div>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
        @if (count($categories) > 8)
            <div class="absolute w-full cursor-pointer justify-between expand-button flex bg-white bottom-0 add">
                <div class="w-full py-3 flex-shrink-0 md:mx-0 mx-auto text-center p-1 relative  ltr:md:text-left rtl:md:text-right">
                    <a class="flex justify-between text-center items-center">
                        <span class="text-gray-10 font-medium text-sm text-one uppercase ltr:ml-2.5 rtl:mr-2.5">{{ __('See All Categories') }} </span>
                        <svg class="ltr:mr-2 rtl:ml-2" width="11" height="7" viewBox="0 0 11 7"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 5L4.83564 5.74741L5.5 6.33796L6.16436 5.74741L5.5 5ZM0.335636 1.74741L4.83564 5.74741L6.16436 4.25259L1.66436 0.252591L0.335636 1.74741ZM6.16436 5.74741L10.6644 1.74741L9.33564 0.252591L4.83564 4.25259L6.16436 5.74741Z" fill="#898989" />
                        </svg>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
