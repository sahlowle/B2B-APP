"use strict";
if ($('.main-body .page-wrapper').find('#currency-setting-container').length) {
    $(".select2").select2({
        placeholder: jsLang("Nothing selected"),
        allowClear: true,
    });
    $(document).on('init.dt', function () {
        $(".dataTables_length").remove();
        $('#currencyDataTable').removeAttr('style');
        $('#currencyDataTable_filter').remove();
    });
    var formId = 0;
    var formType = '';
    dataTable('#currencyDataTable', [4]);
    var exchangeResource = {
      'exchangerate-api': '(https://www.exchangerate-api.com)'
    };

    setTimeout(() => {
        $('#exchange_resource').trigger("change");
    }, 1000);

    $(document).on('click', '.tab-name', function () {
        let tabName = $(this).attr('data-id');
        let tabType = $(this).attr('data-type');
        $('#header_title').text(tabName);

        if (tabType != 'currency') {
            $('#add_currency').addClass('display-none');
            $('#update_exchange_all').addClass('display-none');
        } else {
            $('#add_currency').removeClass('display-none');
            $('#update_exchange_all').removeClass('display-none');
        }
    });

    function dataTable(tableSeclector, target) {
        $(tableSeclector).DataTable({
            "columnDefs": [{
                "targets": target,
                "orderable": false
            }],
            "language": {
                "url": app_locale_url
            },
            "pageLength": parseInt(row_per_page),
            "order": [[0, 'asc']]
        });
    }

    $(document).on('click', '#add_currency', function () {
        var action = $(this).attr("data-action");
        $('#currency_form').attr('action', action);
        formReset();
        $('#currency_method').val('post');
    });

    $(document).on('change', '#exchange_resource', function () {
        $('#exchange_url').text(exchangeResource[$(this).val()] ?? null);
    });

    function formReset() {
        $('#currency_form').trigger("reset");
    }

    $(document).on('click', '.edit_currency', function () {
        var url = $(this).attr("data-url");
        var action = $(this).attr("data-action");
        $('#currency_form').attr('action', action);
        var id = $(this).attr("id");
        formReset();
        $('#currency_method').val('put');
        $.ajax({
            url: url,
            data: {
                id: id,
                "_token": token
            },
            type: 'get',
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 1) {
                    $('#currency_id').val(data.records.currency_id).trigger('change');
                    $('#exchange_rate').val(data.records.exchange_rate);
                    $('#allow_decimal_number').val(data.records.allow_decimal_number);
                    $('#custom_symbol').val(data.records.custom_symbol);
                }
            }
        });

    });


    $(document).on('click', '.delete_currency', function () {
        formId = $(this).attr('data-id');
    });


    $('#confirmDeleteSubmitBtn').on('click', function () {
        $('#delete-currency-' + formId).submit();
    })

    $('#update_exchange_all').on('click', function () {
        var url = $(this).attr("data-action");
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                update_type: 'all',
            },
            beforeSend: function(xhr) {
                $('.custom_loader').replaceWith('<div class="spinner-border spinner-border-sm ml-2 custom_loader" role="status"></div>');
            },
            success: function(result){
                if (result.status == 1) {
                    location.href = redirectRoute;
                } else {
                    $('.custom_loader').replaceWith('<span class="feather icon-download-cloud custom_loader">&nbsp;</span>');
                    triggerNotification("alert-danger", jsLang('Update failed!'));
                }
            },
            error: function() {
                $('.custom_loader').replaceWith('<span class="feather icon-download-cloud custom_loader">&nbsp;</span>');
                triggerNotification("alert-danger", jsLang('Update failed!'));
            }
        });
    })

    $('.update_exchange_single').on('click', function () {
        var url = $(this).attr("data-action");
        let currencyId = $(this).attr('data-id');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                update_type: 'single',
                multi_currency_id: currencyId,
            },
            beforeSend: function(xhr) {
                $('.custom_loader_'+currencyId).replaceWith('<div class="spinner-border spinner-border-sm ml-2 custom_loader_'+currencyId+'" role="status"></div>');
            },
            success: function(result){
                if (result.status == 1) {
                  $('#exchnage-rate-'+currencyId).html(result.exchange_rate);
                  $('.custom_loader_'+currencyId).replaceWith('<i class="feather icon-download-cloud custom_loader_'+currencyId+'"></i>');
                    triggerNotification("alert-success", jsLang('Successfully Updated'));
                } else {
                    $('.custom_loader_'+currencyId).replaceWith('<i class="feather icon-download-cloud custom_loader_'+currencyId+'"></i>');
                    triggerNotification("alert-danger", jsLang('Update failed!'));
                }
            },
            error: function() {
                $('.custom_loader_'+currencyId).replaceWith('<i class="feather icon-download-cloud custom_loader_'+currencyId+'"></i>');
                triggerNotification("alert-danger", jsLang('Update failed!'));
            }
        });
    })

    const triggerNotification = (className, msg) => {
        $(".notification-msg-bar").find(".notification-msg").html(msg);
        $(".notification-msg-bar").removeClass("smoothly-hide");
        setTimeout(() => {
            $(".notification-msg-bar").addClass("smoothly-hide"),
                $(".notification-msg-bar").find(".notification-msg").html("");
        }, 1500);
    };

    $(document).on('keyup', '.positive-float-number', function () {
        if ($(this).val() == 0 || (this).val() < 0) {
            $(this).val('');
        }
    });
}
