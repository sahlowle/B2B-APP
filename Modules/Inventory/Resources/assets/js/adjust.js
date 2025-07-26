'use strict';
if ($('.main-body .page-wrapper').find('#product-adjust-container').length) {
    const available = `
        <option value="Correction">${ jsLang('Correction') }</option>
        <option value="Count">${ jsLang('Count') }</option>
        <option value="Received">${ jsLang('Received') }</option>
        <option value="Return_restock">${ jsLang('Return restock') }</option>
        <option value="Damaged">${ jsLang('Damaged') }</option>
        <option value="Theft_or_loss">${ jsLang('Theft or loss') }</option>
        <option value="Promotion_or_donation">${ jsLang('Promotion or donation') }</option>
        `;

    const unavailable = `
     <option value="Other">${ jsLang('Other') }</option>
     <option value="Damaged">${ jsLang('Damaged') }</option>
     <option value="Quality_control">${ jsLang('Quality Control') }</option>
     <option value="safety_stock">${ jsLang('Safety stock') }</option>
    `;
    
    const availableQty = parseFloat($('#available').val());
    var changeQty = availableQty;
    
    $(document).on('change', '#adjust_type', function() {
        $('#available').val(availableQty);
        $('#quantity').val(0)
        changeQty = availableQty;
        $('#availabe_lbl').text(jsLang('Available stock'));
        $('#reason_lbl').text(jsLang('Reason'));
        
        if ($(this).val() == 'unavailable') {
            $('#quantity').attr('min', 0);
            $('#quantity').attr('max', changeQty);
        } else if ($(this).val() == 'available'){
            $('#quantity').attr('min', 0);
            $('#quantity').attr('max', totalUnavailable);
            changeQty = parseFloat(totalUnavailable);
            $('#availabe_lbl').text(jsLang('Unavailable stock'));
            $('#reason_lbl').text(jsLang('Reason from'));
        } else {
            $('#quantity').attr('min', -changeQty);
            $('#quantity').removeAttr('max');
        }
        
        $('#quantity').trigger('change');

        $('#reason')
            .find('option')
            .remove()
            .end()
            .append($(this).val() == 'unavailable' || $(this).val() == 'available'  ? unavailable : available)
            .val($(this).val() == 'unavailable' || $(this).val() == 'available' ? 'Other' : 'Correction')
            .trigger('change')
        ;
    });

    $(document).on('keyup change', '#quantity', function() {
        let qty = parseFloat($(this).val());

        if ($(this).val().length > 0) {
            if ($('#adjust_type').val() == 'unavailable' || $('#adjust_type').val() == 'available') {
                $('#available').val(changeQty - qty);
            } else {
                $('#available').val(changeQty + qty);
            }
        }
        
    });

    $(document).on('keyup change', '.inputQty', function() {
        let maxVal = parseFloat($(this).attr('max'));
        let minVal = parseFloat($(this).attr('min'));
        if (parseFloat($(this).val()) > 0 && parseFloat($(this).val()) > maxVal) {
            $(this).val(maxVal);
            $(this).trigger('change');
        } else if (parseFloat($(this).val()) < 0 && parseFloat($(this).val()) < minVal) {
            $(this).val(minVal);
            $(this).trigger('change');
        }
    });
}


if ($('.main-body .page-wrapper').find('#stock-list-container').length) {
    
    function chekAdjustButton() {
        if ($('#location_id').val().length > 0) {
            return true;
        }

        return false;
    }

    $(document).on('click', '.adjust_page', function(e) {
        if (!chekAdjustButton()) {
            e.preventDefault();

            swal(jsLang('Please filter by selecting a location first!'), {
                icon: "error",
                buttons: [false, jsLang('Ok')],
            });
        }
        
    });
}
