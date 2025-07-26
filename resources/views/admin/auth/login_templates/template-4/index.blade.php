
@extends('admin.layouts.app2')
@section('page_title', __('Log In'))

@section('content')
    <div class="auth-wrapper">
        <div class="auth-content subscribe">
            <div class="card">
                <div class="row no-gutters">
                    <div class="col-md-4 col-lg-6 d-none d-md-flex d-lg-flex theme-bg align-items-center justify-content-center">
                        <img alt="lock images" class="img-fluid" src="{{ url('resources/views/admin/auth/login_templates/template-4/' . $settings['template-4']['data']['file']) }}">
                    </div>
                    <div class="col-md-8 col-lg-6">
                        <div class="card-body text-center py-4">
                            <div class="row justify-content-center">
                                <div class="col-sm-10">
                                    @yield('sub-content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('admin.auth.partial.login-js')
@endsection
    