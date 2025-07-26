'use strict';
$('#address-settings-container .visible').on('change', function() {
    var $this = $(this);
    var isChecked = $this.is(':checked');
    var name = $this.attr('name');

    var $fieldParent = $this.closest('.field-parent');
    var $requiredFields = $fieldParent.find('.required');

    $requiredFields.prop('disabled', !isChecked);
    
    if (!isChecked) {
        $requiredFields.prop('checked', isChecked);
    }

    if (name === 'address_country_visible') {
        $('input[name="address_state_visible"][type="checkbox"], input[name="address_state_required"][type="checkbox"], input[name="address_city_visible"][type="checkbox"], input[name="address_city_required"][type="checkbox"], input[name="address_zip_visible"][type="checkbox"], input[name="address_zip_required"][type="checkbox"]').prop('checked', false).prop('disabled', !isChecked);
    }
    
    if (name === 'address_first_name_visible') {
        $('input[name="address_last_name_visible"][type="checkbox"], input[name="address_last_name_required"][type="checkbox"]').prop('checked', false).prop('disabled', !isChecked);
    }
});

// Function to handle change event on input with name 'address_country_required'
$('#address-settings-container input[name="address_country_required"]').on('change', function() {
    var isChecked = $(this).is(':checked');
    var field = $('input[name="address_state_required"][type="checkbox"], input[name="address_city_required"][type="checkbox"]');
    if (!isChecked) {
        field.prop('checked', false).prop('disabled', true);
    } else {
        field.prop('disabled', false);
    }
});

$('#address-settings-container .required').on('change', function() {
    var $this = $(this);
    
    if ($this.is(':checked')) {
        $this.closest('.field-parent').find('.visible').prop('checked', true);
    }
});
