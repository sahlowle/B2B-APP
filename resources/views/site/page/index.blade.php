@extends('../site/layouts.app')

@section('page_title', $page->name)

@section('seo')
    @include('site.page.seo')
@endsection

@section('css')
    @if ($page->css)
        <style>
            {!! $page->css !!}
        </style>
    @endif
@endsection

@section('content')
    @if ($page->css)
    <div>
        {!! $page->description !!}
    </div>
    @else
    <section class="text-gray-600 body-font">
        <div class="layout-wrapper px-4 xl:px-0">
            <div class="flex flex-col text-center w-full mb-10 mt-10">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ $page->name }}</h1>
            </div>
            <div class="blog-page-description">
                {!! $page->description !!}
            </div>
        </div>
    </section>
    @endif
@endsection

