@extends('admin.layouts.app')
@section('page_title', __('Themes'))
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container theme-layout-container">
        <div>
            <div class="card-header">
                <h5>{{ __('Themes') }}</h5>
            </div>
            <div class="table-border-style p-0">
                <div class="parent mt-3">
                    <div class="row">
                        @php
                            $themes = App\Facades\Theme::all();
                        @endphp
                        @foreach ($themes as $theme)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card h-100">
                                    <div class="img-responsive h-200 overflow-hidden">
                                        <img class="w-100" src="{{ $theme->thumbnailUrl() }}" alt="">
                                    </div>
                
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate">
                                            {{ is_null($theme->title()) ? $theme->name() : $theme->title() }}
                                        </h5>

                                        @if ($theme->description())
                                        <p class="card-text text-secondary text-truncate" title="{{ $theme->description() }}">
                                            {{ $theme->description() }}
                                        </p>
                                        @endif

                                        <div class="row g-1 g-lg-0">
                                            @if ($theme->author())
                                            <div class="col-12 col-lg">
                                                {{ __("By") }}:
                                                <a href="{{ $theme->author_url() }}" target="_blank">{{ $theme->author() }}</a>
                                            </div>
                                            @endif

                                            @if ($theme->version())
                                            <div class="col-12 col-lg-auto">
                                                {{ __("Version") }}:
                                                <strong>{{ $theme->version() }}</strong>
                                            </div>                                                
                                            @endif
                                        </div>
                                    </div>
                
                                    <div class="card-footer text-center bg-light p-3" style="height: 65px">
                                            @if(preference('active_theme') == $theme->name())
                                            <span class="badge badge-success float-left f14 mt-2">{{ __("Active") }}</span>
                                            @endif

                                            @if (preference('active_theme') == $theme->name())
                                                @if ( $theme->customize_url())
                                                    <a href="{{ $theme->customize_url() }}" class="btn btn-sm btn-mv-primary float-right">{{ __('Customize') }}</a>
                                                @endif
                                            @else
                                                <a href="{{ route('themes.active', ['slug' => $theme->name() ]) }}" class="btn btn-sm btn-primary float-right">
                                                    <i class="feather icon-check me-1"></i>     
                                                    {{ __("Activate") }}    
                                                </a>
                                            @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
