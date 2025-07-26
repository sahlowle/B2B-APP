'use strict';

function generateCheckboxHTML(data, containerId) {
    var checkboxData = '';
    for (const key in data) {
        checkboxData += `<div class="d-flex mt-10p">
            <div class="ltr:me-3 rtl:ms-3">
                <input type="hidden" name="${key}" value="0">
                <div class="switch switch-bg d-inline m-r-10">
                    <input type="checkbox" name="${key}" class="checkActivity" id="${key}" value="1" ${data[key]['default_value'] ? 'checked' : ''} ${data[key]['is_disabled'] ? 'disabled' : ''}>
                    <label for="${key}" class="cr"></label>
                </div>
            </div>
            <div class="mt-2">
                <span>${data[key]['title']}</span>
            </div>
        </div>`;
    }
    
    $(`#${containerId}`).html(checkboxData);
}

function generateLocationHTML(data, containerId) {
    if (!data) {
        $(`#${containerId}`).html('');
        return;
    }
    
    let html = '<div class="mt-30p b-bottom-ddd pb-2">';
    html += `<label for="">${jsLang("Location")}</label>`;
    html += '</div>';
    html += '<div id="custom_field_location">';

    for (const key in data) {
        const location = data[key];
        if (location.values && location.values.length > 0) {
            html += '<div class="form-group row">';
            html += `<label for="${key}" class="col-sm-12 control-label require">${location.title}</label>`;
            html += '<div class="col-sm-12">';
            html += `<select class="form-control select2-custom inputFieldDesign" name="${key}" id="${key}">`;
            
            for (const value of location.values) {
                var formatValue = value.charAt(0).toUpperCase() + value.slice(1).replaceAll('_', ' ');
                html += `<option value="${value}">${formatValue}</option>`;
            }
            
            html += '</select>';
            html += '</div>';
            html += '</div>';
        }
    }

    html += '</div>';

    $(`#${containerId}`).html(html);
    $('.select2-custom').select2();
}

function hideRulesField() {
    var $rulesFormGroup = $('#rules').closest('.form-group');
    var fieldValue = $('#field_to').val();
    var isSelected = fieldValue === 'products' || fieldValue === 'orders';

    $rulesFormGroup.toggleClass('d-none', isSelected);
}

$('#field_to').on('change', function() {
    var visibility = belongsTo[$(this).val()]['visibility'];
    var options = belongsTo[$(this).val()]['options'];
    var location = belongsTo[$(this).val()]['location'];

    generateCheckboxHTML(visibility, 'custom_field_visibility');
    generateCheckboxHTML(options, 'custom_field_options');
    generateLocationHTML(location, 'custom_field_location');
    hideRulesField();
});

$('#type').on('change', function() {
    const selectedType = $(this).val();
    const selectedTypeData = inputTypes[selectedType];

    const optionHtml = selectedTypeData['need_option'] ? `
        <div class="form-group row mb-10">
            <label for="name" class="control-label require ltr:ps-3 rtl:pe-3">
                ${jsLang('Options')}
            </label>
            <div class="col-sm-12">
                <textarea class="form-control" name="options" id="options">${fieldOptions}</textarea>
                <small class="${selectedTypeData['option_note'] ? '' : 'd-none'} form-text text-muted">${selectedTypeData['option_note']}</small>
            </div>
        </div>` : '';

    const defaultBox = selectedTypeData['default'];

    const defaultValueHtml = `
        <div class="form-group row mb-10 ${defaultBox['class']}">
            <label for="default_value" class="control-label ltr:ps-3 rtl:pe-3">${jsLang('Default Value')}
            </label>
            <div class="col-sm-12">
                <${defaultBox['tag']} type="${defaultBox['type']}" value="${defaultValue}" class="form-control form-width ${defaultBox['tag'] == 'input' ? 'inputFieldDesign' : '' } " id="default_value" name="default_value" >${defaultBox['tag'] == 'textarea' ? defaultValue : ''}</${defaultBox['tag']}>
                <small class="form-text text-muted">${ jsLang('Predefined value assumed if no other value is provided.')}</small>
            </div>
        </div>`;

    $('#custom_field_option').html(optionHtml);
    $('#custom_field_default_value').html(defaultValueHtml);
});

$('.custom-field-datepicker').each(function() {
    $(this).daterangepicker(dateSingleConfig($(this).val() == '' ? '2000-01-01' : $(this).val()));
})

$(function() {
    $('.select2-custom').select2();
    hideRulesField();
    
    $('.accessibility-parent .checkbox:nth-child(2)').on('change', function() {
        const $this = $(this);
        const $checkboxInput = $this.closest('.accessibility-parent').find('.checkbox:nth-child(1) input:nth-child(2)');
        const $checkboxLabel = $this.closest('.accessibility-parent').find('.checkbox:nth-child(1) label');
    
        if ($this.find('input:nth-child(2)').is(':checked')) {
            $checkboxInput.prop({ checked: true, disabled: true });
            $checkboxLabel.removeClass('opacity-100').addClass('opacity-50');
        } else {
            $checkboxInput.prop('disabled', false);
            $checkboxLabel.removeClass('opacity-50').addClass('opacity-100');
        }
    });
    
    if ($('.show-custom-fields-main-section').find('input, textarea, select').length == 0) {
        $('.show-custom-fields-main-section').remove();
    }
})
