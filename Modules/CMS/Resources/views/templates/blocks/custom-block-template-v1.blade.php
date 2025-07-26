<section dir="ltr"
    class="{{ $component->full == 1 ? '' : 'layout-wrapper px-4 xl:px-0' }} my-10 md:my-12"
    style="margin-top:{{ $component->mt }};margin-bottom:{{ $component->mb }};">
    {!! $component->content !!}
</section>
