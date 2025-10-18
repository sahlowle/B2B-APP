<div class="mr-35p mt-10-res">
    <div class="checkbox checkbox-primary d-inline w-space align-items-center float-n {{ languageDirection() == 'ltr' ? 'float-right' : 'float-left' }}">
        <input type="hidden" name="meta_enable_b2b[{{ $idx }}]"
               value="0">
        <input data-bs-toggle="collapse" {{ $variation->meta_enable_b2b == '1' ? 'checked' : '' }}
        href="#{{ $b2bId }}" type="checkbox"
               name="meta_enable_b2b[{{ $idx }}]" id="{{ $b2bId }}"
               class="{{ $variation->meta_enable_b2b == '1' ? 'collapse show' : 'collapsed collapse' }}"
               value="1">
        <label for="{{ $b2bId }}"
               class="crv sp-title d-flx-n">{{ __('Enable B2B?') }}</label>
    </div>
</div>
