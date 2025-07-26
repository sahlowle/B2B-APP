
@extends('admin.layouts.app2')
@section('page_title', __('Log In'))
@section('content')
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <div class="card">
                <div class="card-body text-center py-4">
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
    