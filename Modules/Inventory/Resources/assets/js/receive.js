if ($('.main-body .page-wrapper').find('#purchase-receive-container').length) {

    $(document).on('change', '.inputReceive', function() {
        checkValidation('.inputReceive');
    });

    $(document).on('change', '.inputReject', function() {
        checkValidation('.inputReject');
    });
    
    function checkValidation(selector)
    {
        $(selector).each(function(i, v) {
            let qty = parseFloat($(this).attr('data-qty'));
            let rec = parseFloat($(this).attr('data-rec'));
            let rej = parseFloat($(this).attr('data-rej'));
            let inputVal = 0;
            
            if (selector == '.inputReceive') {
                inputVal = parseFloat($(this).val()) + parseFloat($(this).closest('td').next().find('input.inputReject').val());
            } else if (selector == '.inputReject') {
                inputVal = parseFloat($(this).val()) + parseFloat($(this).closest('td').prev().find('input.inputReceive').val());
            }
            
            let totalOperateQty = inputVal + rec + rej;

            if (totalOperateQty > qty) {
                $(this).addClass('error');
                $(this).parent().parent().find('.inputReject').addClass('error');
                $('#error_message').html(jsLang('Sum of receive & reject value not more than') + ' '+ (qty - (rec + rej)));
                $('#btnSubmit').prop("disabled", true);
                return false;
            } else {
                $(this).removeClass('error');
                $(this).parent().parent().find('.inputReject').removeClass('error');
                $('#btnSubmit').prop("disabled", false);
                $('#error_message').html('');
            }
            
        });
    }
}
