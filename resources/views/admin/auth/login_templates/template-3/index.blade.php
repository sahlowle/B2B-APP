
@extends('admin.layouts.app2')
@section('page_title', __('Log In'))
@section('css')
    <style>
        :root {
            --bg-image: url({{ url('resources/views/admin/auth/login_templates/template-3/' . $settings['template-3']['data']['file']) }})
        }
    </style>
    <link rel="stylesheet" href="{{ asset('public/datta-able/css/layouts/dark.min.css') }}">
@endsection
@section('content')
    @php
        $isDarkMode = true;
    @endphp
    <div class="auth-wrapper aut-bg-img">
        <div class="auth-content">
            <div class="text-white">
                <div class="card-body text-center">
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
    