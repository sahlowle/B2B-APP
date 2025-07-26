<section class="md:flex gap-5 mt-5">
    <div class="grid py-10 grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 2xl:grid-cols-5 gap-x-3 md:gap-x-5 xl:gap-x-8 gap-y-5 lg:gap-y-5 xl:lg:gap-y-7 2xl:gap-y-8">
        @foreach ($allProducts as $item)
            @include('site.layouts.section.card-one')
        @endforeach
    </div>
</section>
<section class="z-index-1">
    {{ $allProducts->links('pagination::tailwind') }}
</section>
