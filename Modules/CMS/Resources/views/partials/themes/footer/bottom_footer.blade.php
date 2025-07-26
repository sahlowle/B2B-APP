<div class="row">
    <div class="col-sm-12">
        <div class="form-group row">
            <label for="meta_title"
                class="col-sm-3 text-left col-form-label ">{{ __('Show Copyright') }}</label>
            <div class="col-sm-6">
                <input type="hidden"
                    name="{{ $layout }}_template_footer[bottom][status]"
                    value="0">
                <div class="switch switch-bg d-inline m-r-10">
                    <input type="checkbox"
                        name="{{ $layout }}_template_footer[bottom][status]"
                        {{ isset($footer['bottom']['status']) && $footer['bottom']['status'] ? 'checked' : '' }}
                        value="{{ isset($footer['bottom']['status']) ? $footer['bottom']['status'] : '' }}"
                        id="show-bottom-footer">
                    <label for="show-bottom-footer" class="cr"></label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group row conditional" data-if="#show-bottom-footer">
                    <label for="footer-bottom-title"
                        class="col-sm-3 text-left col-form-label ">{{ __('Text Color') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control demo inputFieldDesign"
                            data-control="hue"
                            name="{{ $layout }}_template_footer[bottom][text_color]"
                            value="{{ isset($footer['bottom']['text_color']) ? $footer['bottom']['text_color'] : '' }}">
                    </div>
                </div>
                <div class="form-group row conditional" data-if="#show-bottom-footer">
                    <label for="footer-bottom-title"
                        class="col-sm-3 text-left col-form-label ">{{ __('Background Color') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control demo inputFieldDesign"
                            data-control="hue"
                            name="{{ $layout }}_template_footer[bottom][bg_color]"
                            value="{{ isset($footer['bottom']['bg_color']) ? $footer['bottom']['bg_color'] : '' }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <label for="footer-bottom-border"
                        class="col-sm-3 text-left col-form-label">{{ __('Top Border Color') }}</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control demo inputFieldDesign"
                            data-control="hue"
                            name="{{ $layout }}_template_footer[bottom][border_top]"
                            value="{{ isset($footer['bottom']['border_top']) ? $footer['bottom']['border_top'] : '#000000' }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row conditional" data-if="#show-bottom-footer">
            <label for="footer-bottom-title"
                class="col-sm-3 text-left col-form-label ">{{ __('Content') }}</label>
            <div class="col-sm-6">
                <input type="text" class="form-control"
                    id="footer-bottom-title" name="{{ $layout }}_template_footer[bottom][title]"
                    value="{{ isset($footer['bottom']['title']) ? $footer['bottom']['title'] : '' }}">
            </div>
        </div>
        <div class="form-group row conditional" data-if="#show-bottom-footer">
            <label for="footer-bottom-position"
                class="col-sm-3 text-left col-form-label ">{{ __('Alignment') }}</label>
            <div class="col-md-8">
                <div class="form-group d-inline mr-2">
                    <div class="radio radio-warning d-inline">
                        <input type="radio"
                            name="{{ $layout }}_template_footer[bottom][position]"
                            value="left" id="footer-bottom-direction-left"
                            {{ isset($footer['bottom']['position']) && $footer['bottom']['position'] == 'left' ? 'checked' : '' }}>
                        <label for="footer-bottom-direction-left"
                            class="cr">{{ __('Left') }}</label>
                    </div>
                </div>
                <div class="form-group d-inline mr-2">
                    <div class="radio radio-warning d-inline">
                        <input type="radio"
                            name="{{ $layout }}_template_footer[bottom][position]"
                            value="center" id="footer-bottom-direction-center"
                            {{ isset($footer['bottom']['position']) && $footer['bottom']['position'] == 'center' ? 'checked' : '' }}>
                        <label for="footer-bottom-direction-center"
                            class="cr">{{ __('Center') }}</label>
                    </div>
                </div>
                <div class="form-group d-inline mr-2">
                    <div class="radio radio-warning d-inline">
                        <input type="radio"
                            name="{{ $layout }}_template_footer[bottom][position]"
                            value="right" id="footer-bottom-direction-right"
                            {{ isset($footer['bottom']['position']) && $footer['bottom']['position'] == 'right' ? 'checked' : '' }}>
                        <label for="footer-bottom-direction-right"
                            class="cr">{{ __('Right') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
