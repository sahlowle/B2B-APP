
@extends('admin.layouts.app2')
@section('page_title', __('Log In'))
@section('content')
    <div class="auth-wrapper">
        <div>
            <div class="card bt-yellow-5 w-450 pt-3">
                <span class="multi-logo m-t-20 text-center">
                    @php
                        $logo = App\Models\Preference::getLogo('company_logo');
                    @endphp
                    <img class="admin-login-logo img-fluid" src="{{ $logo }}" alt="{{ trimWords(preference('company_name'), 17)}}">
                </span>
                <div class="card-body text-center admin-login">
                    @yield('sub-content')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('admin.auth.partial.login-js')
@endsection
    