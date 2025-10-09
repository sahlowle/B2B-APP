<div class="col-md-12">
    <div class="card">
        <div class="card-block">
            <div class="card-content black-text">
                <div class="center-align text-center">
                    <h5 class="card-title">{{ __("Verify Envato Purchase Code") }}</h5>
                    <hr>
                </div>
                @if(isset($responseError))
                    <div class="text-danger">
                        {{ $responseError }}
                    </div>
                @else
                    <div class="text-danger text-center">
                        {{ __('Please verify the subscription addon for access this addon features.') }}
                    </div>
                @endif
                <form class="form-horizontal" action="{{ route('subscription.verify') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="username" class="mb-3 form-control form-control-lg" id="envatoUsername" name="envatoUsername" value="{{ old('envatoUsername') }}" placeholder="{{ __('Envato username') }}">
                        @if (isset($errors) && $errors->has('envatoUsername'))
                            <small class="text-danger">{{$errors->first('envatoUsername')}}</small>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="text" id="envatopurchasecode" class="mb-3 form-control form-control-lg" id="envatopurchasecode" name="envatopurchasecode" value="{{ old('envatopurchasecode') }}" placeholder="{{ __('Subscription purchase code') }}">
                        @if (isset($errors) && $errors->has('envatopurchasecode'))
                            <small class="text-danger">{{$errors->first('envatopurchasecode')}}</small>
                        @endif
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="right">
                                <button type="submit" class="btn py-2 custom-btn-submit {{ languageDirection() == 'ltr' ? 'float-right' : 'float-left' }}">{{ __("VERIFY PURCHASE CODE") }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
