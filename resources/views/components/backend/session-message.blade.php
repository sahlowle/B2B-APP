@error('fail')
<div class="flex justify-center">
    <p class="password-validation-error block text-center text-11 mt-1 text-red-500 p-2 font-bold text-sm mb-2">{{ $message }}</p>
</div>
@enderror
@php
$colors = ['fail' => 'text-red-500', 'info' => 'text-red-500', 'success' => 'text-green-1']
@endphp
@foreach (['success', 'fail', 'info'] as $msg)
@if ($message = Session::get($msg))
    <div class="flex justify-center">
        <p class="{{ $colors[$msg] }} block text-center text-11 mt-1 p-2 font-bold text-sm mb-2">{{ $message }}</p>
    </div>
@endif
@endforeach
