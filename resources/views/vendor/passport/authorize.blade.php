<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - {{ __("Authorization") }}</title>

    <!-- Styles -->
    <link href="{{ asset('public/datta-able/plugins/bootstrap-v5/css/bootstrap.min.css') }}" rel="stylesheet">

   <link rel="stylesheet" href="{{ asset('public/dist/css/laravel-authrization.min.css') }}">
</head>
<body class="passport-authorize">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">
                        {{ __("Authorization Request") }}
                    </div>
                    <div class="card-body">
                        <!-- Introduction -->
                        <p> {!! __(":x is requesting permission to access your account.", ["x" => "<strong>{$client->name}</strong>"]) !!}</p>

                        <!-- Scope List -->
                        @if (count($scopes) > 0)
                            <div class="scopes">
                                    <p><strong>{{ __("This application will be able to") }}:</strong></p>

                                    <ul>
                                        @foreach ($scopes as $scope)
                                            <li>{{ $scope->description }}</li>
                                        @endforeach
                                    </ul>
                            </div>
                        @endif

                        <div class="buttons">
                            <!-- Authorize Button -->
                            <form method="post" action="{{ route('passport.authorizations.approve') }}">
                                @csrf

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                                <button type="submit" class="btn btn-success btn-approve">{{ __("Authorize") }}</button>
                            </form>

                            <!-- Cancel Button -->
                            <form method="post" action="{{ route('passport.authorizations.deny') }}">
                                @csrf
                                @method('DELETE')

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                                <button class="btn btn-danger">{{ __("Cancel") }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
