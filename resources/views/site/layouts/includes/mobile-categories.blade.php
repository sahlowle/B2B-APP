@php
    $uncategorized = App\Models\Category::parents();
    $categories = $uncategorized->where('id', '!=', 1);
@endphp
<ul class="flex flex-col space-y-6 dm-sans font-medium text-sm">
    @foreach ($categories as $category)
    @php $checkChildCategory = $category->childrenCategories @endphp

    <li>
        <div class="flex justify-between items-center">
            <p><a href="{{ route('site.productSearch', ['categories' => $category->slug]) }}">{{ $category->name }}</a></p>
            <h3>
                <a class="clicks rotate" href="javascript:void(0)">
                    <svg width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.870679 3.60997e-07L-3.02758e-07 0.948839L3.25864 4.5L3.18147e-07 8.05116L0.87068 9L5 4.5L0.870679 3.60997e-07Z" fill="#DFDFDF"/>
                    </svg>
                </a>
            </h3>
        </div>
        @if ($checkChildCategory)
        <ul class="mt-3">
            @foreach ($category->childrenCategories as $childCategory)
            <li>
                <div class="flex justify-between items-center">
                    <p><a href="{{ route('site.productSearch', ['categories' => $childCategory->slug]) }}">{{ $childCategory->name }}</a></p>
                    <h3>
                        <a class="clicks rotate" href="javascript:void(0)">
                            <svg width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.870679 3.60997e-07L-3.02758e-07 0.948839L3.25864 4.5L3.18147e-07 8.05116L0.87068 9L5 4.5L0.870679 3.60997e-07Z" fill="#DFDFDF"/>
                            </svg>
                        </a>
                    </h3>
                </div>
                @if ($childCategory->categories->count() > 0)
                <ul>
                    @foreach ($childCategory->categories as $grandChildCategory)
                    <li>
                        <div class="flex justify-between items-center">
                            <p><a href="{{ route('site.productSearch', ['categories' => $grandChildCategory->slug]) }}">{{ $grandChildCategory->name }}</a></p>
                        </div>
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
</ul>
<div class="mt-5">
    <a class="flex items-center">
        <span class="dm-sans font-medium text-sm cursor-pointer uppercase">
            {{ __('See All Categories') }}
        </span>
        <svg class="ltr:ml-2.5 rtl:mr-2.5 neg-transition-scale" width="12" height="8" viewBox="0 0 12 8" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M10 4L10.7071 3.29289L11.4142 4L10.7071 4.70711L10 4ZM1 5C0.447715 5 0 4.55228 0 4C0 3.44772 0.447715 3 1 3V5ZM7.70711 0.292893L10.7071 3.29289L9.29289 4.70711L6.29289 1.70711L7.70711 0.292893ZM10.7071 4.70711L7.70711 7.70711L6.29289 6.29289L9.29289 3.29289L10.7071 4.70711ZM10 5H1V3H10V5Z"
                fill="#DFDFDF" />
        </svg>
    </a>
</div>
