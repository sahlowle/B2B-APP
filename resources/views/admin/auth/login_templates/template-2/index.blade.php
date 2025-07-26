
@extends('admin.layouts.app2')
@section('page_title', __('Log In'))
@section('css')
    <style>
        /* public/datta-able/bg-images/bg4.jpg */
        :root {
            --bg-image: url({{ url('resources/views/admin/auth/login_templates/template-2/' . $settings['template-2']['data']['file']) }})
        }
    </style>
@endsection
@section('content')
    <div class="auth-wrapper aut-bg-img-side cotainer-fiuid align-items-stretch">
        <div class="row align-items-center w-100 align-items-stretch bg-white">
            <div class="d-none d-lg-flex col-lg-8 aut-bg-img align-items-center d-flex justify-content-center">
                <div class="col-md-8">
                    <h1 class="text-white mb-5">{{ $settings['template-2']['data']['title'] }}</h1>
                    <p class="text-white">{{ $settings['template-2']['data']['description'] }}</p>
                </div>
            </div>
            <div class="col-lg-4 align-items-stret h-100 align-items-center d-flex justify-content-center">
                <div class=" auth-content text-center">
                    <div class="mb-4">
                        <i class="feather icon-unlock auth-icon"></i>
                    </div>
                    @yield('sub-content')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('admin.auth.partial.login-js')
@endsection
    