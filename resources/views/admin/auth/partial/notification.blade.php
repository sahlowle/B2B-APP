@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li class="reset-error-msg">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@foreach (['success', 'danger', 'fail', 'warning', 'info'] as $msg)
    @if($message = Session::get($msg))
        <div class="alert-reset alert alert-{{ $msg == 'fail' ? 'danger' : $msg }}">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong class="reset-success-msg">{{ $message }}</strong>
        </div>
        @break
    @endif
@endforeach
