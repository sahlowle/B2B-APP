<link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/datta-able/plugins/mini-color/css/jquery.minicolors.min.css') }}">
    
@php
    $fields = App\Models\CustomField::with(['customFieldValues' => function($query) use ($relId) {
        $query->where('rel_id', $relId);
    }])->active()->where(['field_to' => $fieldTo])
        ->orderBy('order')->get()->each(function ($item) {
        $item->metaPluck = $item->meta()->pluck('value', 'key');
    });
    
    $frontendFramework = isset($frontendFramework) && in_array($frontendFramework, ['bootstrap', 'tailwind']) ? $frontendFramework : 'bootstrap';
@endphp

@foreach ($fields as $customField)
    @php
        $user = auth()->user();
        $userRoleSlug = optional($user->roles->first())->slug;
        $accessibility = optional($customField->metaPluck)[$userRoleSlug] ?? null;
        $accessibilityData = json_decode($accessibility) ?? (object) [];
        
        $name = "custom_fields[$loop->iteration][value]";

        $isWritable = $accessibilityData->write ?? false;
        $isReadable = $isWritable || $accessibilityData->read ?? false;
        
        $data['bootstrap']['class']['label'] = 'col-sm-' . (isset($labelColumn) ? $labelColumn : 4);
        $data['bootstrap']['class']['main_div'] = 'col-sm-' . $customField->column;
        $data['bootstrap']['class']['checkbox_main_div'] = 'checkbox checkbox-warning checkbox-fill d-block';
        $data['bootstrap']['class']['checkbox_input'] = '';
        $data['bootstrap']['class']['datepicker_main_div'] = 'd-flex date form-width';
        $data['bootstrap']['class']['datepicker_input'] = 'form-control inputFieldDesign rounded-0 ltr:rounded-end rtl:rounded-start custom-field-datepicker';
        $data['bootstrap']['class']['other_tag'] = 'form-control form-width';
        
        $data['tailwind']['class']['label'] = 'dm-sans font-medium text-gray-12 text-sm';
        $data['tailwind']['class']['main_div'] = '';
        $data['tailwind']['class']['checkbox_main_div'] = '';
        $data['tailwind']['class']['checkbox_input'] = 'border border-gray-2 cursor-pointer form-checkbox cart-item-single cart-shop-0';
        $data['tailwind']['class']['datepicker_main_div'] = '';
        $data['tailwind']['class']['datepicker_input'] = 'border-gray-2 rounded-sm w-full h-46p roboto-medium uppercase font-medium text-sm text-gray-10 form-control focus:border-gray-12 ltr:pl-18p rtl:pr-18p';
        $data['tailwind']['class']['other_tag'] = 'block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-2 rounded-sm dark:bg-gray-2 dark:border-gray-0 dark:text-gray-2 focus:border-gray-12 dark:focus:border-purple-500 focus:outline-none form-control';
    @endphp
    
    @if (($customField->metaPluck[$visibility] ?? false) && $isReadable)
        <div class="form-group row {{ $frontendFramework == 'tailwind' ? 'mt-3' : '' }} {{ $customField->type == 'hidden' ? 'display-none' : '' }}">
                <label for="role_id"
                    class="{{ $data[$frontendFramework]['class']['label'] }} control-label {{ $customField->isRequired() ? 'require' : '' }}">{{ $customField->name }}</label>
            <div class="{{ $data[$frontendFramework]['class']['main_div'] }}">
                @if ($isWritable)
                    <input type="hidden" name="custom_fields[{{ $loop->iteration }}][field_id]" value="{{ $customField->id }}">
                    <input type="hidden" name="custom_fields[{{ $loop->iteration }}][field_to]" value="{{ $fieldTo }}">
                    @switch($customField->type)
                        @case('checkbox')
                            @foreach (explode(',', $customField->options) as $option)
                                @php
                                    $defaultValue = json_decode($customField->customFieldValues?->first()?->value, true) ?? explode(',', $customField->default_value);
                                @endphp
                                <div class="{{ $data[$frontendFramework]['class']['checkbox_main_div'] }}">
                                    <input type="checkbox" name="{{ $name }}[]" class="{{ $data[$frontendFramework]['class']['checkbox_input'] }}"
                                        id="{{ $option }}" value="{{ $option }}" {{ in_array($option, $defaultValue) == $option ? 'checked' : '' }}>
                                    <label class="cr" for="{{ $option }}">{{ $option }}</label>
                                </div>
                            @endforeach
                            @break
                        @case('datepicker')
                            <div class="{{ $data[$frontendFramework]['class']['datepicker_main_div'] }} {{ !$loop->first ? 'mt-10p' : '' }}">
                                @if ($frontendFramework == 'bootstrap')
                                    <div class="input-group-prepend">
                                        <i class="fas fa-calendar-alt input-group-text bg-white h-40 rounded-0 ltr:rounded-start ltr:border-end-0 rtl:rounded-end rtl:border-start-0"></i>
                                    </div>
                                @endif
                                @php
                                    $pattern = '/\b\d{4}-\d{2}-\d{2}\b/';
                                    $defaultValue = '';
                                    if (preg_match($pattern, $customField->default_value, $matches)) {
                                        $defaultValue = $matches[0];
                                    }
                                @endphp
                                <input class="{{ $data[$frontendFramework]['class']['datepicker_input'] }}"
                                    type="{{ $frontendFramework == 'bootstrap' ? 'text' : 'date' }}" name="{{ $name }}" value="{{ $customField->customFieldValues?->first()?->value ?? $defaultValue }}" {{ $customField->isRequired() ? 'required' : '' }}
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                            @break
                        @default {{-- text, hidden, textarea, number, select, multiselect, colorpicker, datepicker --}}
                            @php
                                $tag = $customField->typeOption('tag');
                                $type = $customField->typeOption('type');
                                $defaultValue = $customField->customFieldValues?->first()?->value ?? $customField->default_value;
                                $isMultiselect = $customField->typeOption('attribute') == 'multiselect';
                                $tagIsInput = $tag == 'input';
                                $tagIsTextarea = $tag == 'textarea';
                                $tagIsSelect = in_array($tag, ['select', 'multiselect']);
                            @endphp

                            <{{ $tag }} type="{{ $type }}"
                                value="{{ $defaultValue }}"
                                class="{{ $data[$frontendFramework]['class']['other_tag'] }} {{ $customField->type == 'colorpicker' ? 'demo layout-primary-color' : '' }}
                                    {{ $tagIsInput ? 'inputFieldDesign' : '' }}
                                    {{ $tagIsSelect ? 'select2-custom' : '' }}"
                                id="{{ $customField->type . $loop->iteration }}"
                                data-control="{{ $customField->type == 'colorpicker' ? 'hue' : '' }}"
                                name="{{ $name . ($isMultiselect ? '[]' : '') }}"
                                {{ $customField->isRequired() ? 'required' : '' }}
                                {{ $isMultiselect ? 'multiple' : '' }}>{{ $tagIsTextarea ? $defaultValue : '' }} {{-- textarea --}}

                                @if ($tagIsSelect) {{-- select, multiselect --}}
                                    @foreach (explode(',', $customField->options) as $option)
                                    @php
                                        $dbValue = $customField->customFieldValues?->first()?->value;
                                        
                                        if ($isMultiselect) {
                                            $dbValue = json_decode($dbValue, true);
                                        } else {
                                            $dbValue = [$dbValue];
                                        }
                                        
                                        $defaultValue = $dbValue ?? explode(',', $customField->default_value);
                                    @endphp
                                        <option value="{{ $option }}" {{ in_array($option, $defaultValue) == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                @endif
                            </{{ $tag }}>
                    @endswitch
                @elseif ($isReadable)
                    <input type="text" disabled
                        class="{{ $data[$frontendFramework]['class']['other_tag'] }} inputFieldDesign"
                        value="{{ $customField->customFieldValues?->first()?->value ?? $customField->default_value }}">
                @endif
            </div>
        </div>
    @endif
@endforeach

<script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
<script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
<script src="{{ asset('public/datta-able/js/pages/form-picker-custom.min.js') }}"></script>
<script src="{{ asset('public/datta-able/plugins/mini-color/js/jquery.minicolors.min.js') }}"></script>
<script src="{{ asset('public/dist/js/custom/custom-fields.min.js') }}"></script>
