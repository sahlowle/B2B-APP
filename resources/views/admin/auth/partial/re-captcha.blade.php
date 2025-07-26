@if (isRecaptchaActive())
    <div class="mb-1">
        {!! NoCaptcha::renderJs() !!}
        {!! NoCaptcha::display() !!}
    </div>
@endif
