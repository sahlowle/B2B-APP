<hr>
<div class="form-group row">
    <label class="col-sm-3 control-label text-left">
        <dt>{{ __('Appearance') }}</dt>
    </label>
    <div class="col-sm-8 row">
        @if (in_array('width', $fields))
            <div class="col-sm-4 col-md-3">
                <input type="hidden" name="full" value="0">
                <div class="form-group">
                    <div class="switch d-inline m-r-10">
                        <label class="control-label text-left">{{ __('Full Width') }}</label>
                        <input type="checkbox" name="full" id="{{ $sid = uniqid('sw_') }}" value="1"
                            {{ $component && $component->full == 1 ? 'checked' : '' }}>
                        <label for="{{ $sid }}" class="cr -mt-8"></label>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array('margin', $fields))
            <div class="col-sm-4 col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">{{ __('Margin Top') }}</label>
                    <div class="input-group bg-white">
                        @php
                            $mt = $component && $component->mt ? $component->mt : '';

                            if ($mt === "") {
                                $mtValue = "";
                                $unit = "";
                            } else {
                                $mtValue = (int)$mt;
                                $unit = substr($mt, strlen($mtValue));
                            }
                        @endphp
                        <input type="text" class="form-control inputFieldDesign positive-int-number" name="mt"
                            value="{{ $mtValue }}" placeholder="10">
                        <select name="mt_unit">
                            <option @selected($unit == 'px') value="px">Px</option>
                            <option @selected($unit == '%') value="%">%</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">{{ __('Margin Bottom') }}</label>
                    <div class="input-group bg-white">
                        @php
                            $mb = $component && $component->mb ? $component->mb : '';

                            if ($mb === "") {
                                $mbValue = "";
                                $unit = "";
                            } else {
                                $mbValue = (int)$mb;
                                $unit = substr($mb, strlen($mbValue));
                            }
                        @endphp
                        <input type="text" class="form-control inputFieldDesign positive-int-number" name="mb"
                            value="{{ $mbValue }}" placeholder="10">
                        <select name="mb_unit">
                            <option @selected($unit == 'px') value="px">Px</option>
                            <option @selected($unit == '%') value="%">%</option>
                        </select>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array('height', $fields))
            <div class="col-sm-4 col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">{{ __('Height (px)') }}</label>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0 h-40 ltr:rounded-start rtl:rounded-end" id="basic-addon1">px</span>
                            </div>
                            <input type="number" name="height"
                                value="{{ $component && $component->height ? $component->height : '' }}"
                                placeholder="10" class="form-control inputFieldDesign">
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array('rounded', $fields))
            <div class="col-sm-4 col-md-3">
                <input type="hidden" name="rounded" value="0">
                <div class="form-group">
                    <div class="switch d-inline m-r-10">
                        <label class="control-label text-left">{{ __('Round Corner') }}</label>
                        <input type="checkbox" name="rounded" id="{{ $sid = uniqid('sw_') }}" value="1"
                            {{ $component && $component->rounded == 1 ? 'checked' : '' }}>
                        <label for="{{ $sid }}" class="cr -mt-8"></label>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array('full_link', $fields))
            <div class="col-md-3">
                <input type="hidden" name="full_link" value="0">
                <div class="form-group">
                    <div class="switch d-inline m-r-10">
                        <label class="control-label text-left">{{ __('Full Card Link') }}</label>
                        <input type="checkbox" name="full_link" id="{{ $sid = uniqid('sw_') }}" value="1"
                            {{ $component && $component->full_link == 1 ? 'checked' : '' }}>
                        <label for="{{ $sid }}" class="cr -mt-8"></label>
                    </div>
                </div>
            </div>
        @endif
        @if (in_array('card_height', $fields))
            <div class="col-sm-4 col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">{{ __('Card Height') }}</label>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0 h-40 ltr:rounded-start rtl:rounded-end">px</span>
                            </div>
                            <input type="number" name="card_height"
                                value="{{ $component && $component->card_height ? $component->card_height : '' }}"
                                placeholder="10" class="form-control inputFieldDesign">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
