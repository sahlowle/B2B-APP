<div class="card mini-form-holder">
    <div class="order-sec-head cursor-pointer d-flex justify-content-between align-items-center px-3 head-click" href="#language_info"
         aria-expanded="false" data-bs-toggle="collapse">
        <span class="add-title text-lg">{{ __('Language') }}</span>
        <span class="icon-collapse mt-0 toggle-btn">
            <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M4.18767 0.0921111L7.81732 4.65639C8.24162 5.18994 7.87956 6 7.21678 6L0.783223 6C0.120445 6 -0.241618 5.18994 0.182683 4.65639L3.81233 0.092111C3.91 -0.0307037 4.09 -0.0307036 4.18767 0.0921111Z"
                    fill="#2C2C2C"></path>
            </svg>
        </span>
    </div>

    <div id="language_info" class="form-group mb-0 collapse show blockable border-top pb-4p">
        <div class="mt-20p mx-3 d-flx justify-content-between">
            <div>
                <select class="form-control select2clearable" name="product_language_id" id="product_language_id">
                    <option value="">{{ __('Select Language') }}</option>
                    @foreach ($languages as $language)
                        <option value="{{ $language->short_name }}" {{ isset(request()->lang) && $language->short_name == request()->lang || !isset(request()->lang) && $language->short_name != request()->lang && $language->short_name == config('app.locale') ? 'selected' : null }}>
                            {{ $language->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <p class="sp-tag mt-14p mx-3"></p>
    </div>
</div>
