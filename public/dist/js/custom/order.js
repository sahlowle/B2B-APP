"use strict";
if ($('.main-body .page-wrapper').find('#order-list-container, #vendor-order-list-container').length) {
    $('#daterange-btn').daterangepicker(daterangeConfig(startDate, endDate), cbRange);
    cbRange(startDate, endDate);

    $(document).on("click", ".applyBtn, .ranges ul li:nth-child(1), .ranges ul li:nth-child(2), .ranges ul li:nth-child(3), .ranges ul li:nth-child(4), .ranges ul li:nth-child(5), .ranges ul li:nth-child(6), .ranges ul li:nth-child(7)", function (event) {
        event.preventDefault();
        let startFrom = $("#startfrom").val();
        let endto = $("#endto").val();
        var newOptions = {
            startFrom: startFrom,
        };
        var newOptionsTwo = {
            endto: endto,
        };
        let startDate = $("#start_date");
        let end_date = $("#end_date");
        startDate.empty(); // remove old options
        end_date.empty(); // remove old options
        $.each(newOptions, function(key,value) {
            startDate.append($("<option></option>")
                .attr("value", value).text(key));
        });
        $.each(newOptionsTwo, function(key,value) {
            end_date.append($("<option></option>")
                .attr("value", value).text(key));
        });
        $("#start_date option:first").attr('selected','selected');
        $("#end_date option:first").attr('selected','selected');
        $("#start_date").trigger("change");
    });

}
if ($('.main-body .page-wrapper').find('#order-list-container').length) {
    $(document).on("click", "#csv, #pdf", function (event) {
        event.preventDefault();
        window.location = ADMIN_URL + "/orders/" + this.id;

    });
}

if ($('.main-body .page-wrapper').find('#vendor-order-list-container').length) {
    $(document).on("click", "#csv, #pdf", function (event) {
        event.preventDefault();
        window.location = ADMIN_URL + "/orders/" + this.id;

    });
}

const unblockEverything = () => {
    $(".blockUI").each(function () {
        $(this).parent().unblock();
    });
};

const blockElement = (element, _data = {}) => {
    let options = Object.assign(
        {},
        {
            message: `<div class="spinner-border text-warning" role="status"><span class="sr-only">Loading...</span></div>`,
            css: {
                backgroundColor: "transparent",
                border: "none",
            },
        },
        _data
    );
    element.block(options);
};

const finished = () => {
    unblockEverything();
    $('#update-order').text(jsLang('Update'));
    orderUpdate = 0;
}

const triggerNotification = (msg) => {
    $(".notification-msg-bar").find(".notification-msg").html(msg);
    $(".notification-msg-bar").removeClass("smoothly-hide");
    setTimeout(() => {
        $(".notification-msg-bar").addClass("smoothly-hide"),
            $(".notification-msg-bar").find(".notification-msg").html("");
    }, 1500);
};

function addClassDelivery() {
    $(".status").each(function() {
        if (!$(this).hasClass('delivery')) {
            $(this).addClass('delivery');
            $(this).prop('disabled', true);
        }
    })
}

function checkAllStatus() {
    $(".status").each(function() {
        if (!$(this).hasClass('delivery')) {
            return false;
        }
    });

    $('#status').val(finalOrderStatus);
    $('#status').prop('disabled', true);
}

function assignOldStatus() {
    $(".status").each(function() {
        oldDetailStatus[$(this).attr('data-id')] = $(this).val();
    });
}

$(document).on('change', '.status.order-status', function() {
    changeStatus[$(this).attr('data-id')] = $(this).val();
})

var oldDetailStatus = {};
var changeStatus = {};
assignOldStatus();

if ($('.main-body .page-wrapper').find('#invoice-view-container').length) {
    $("#updateNote").on('click', function() {
        blockElement($(this).closest('.order-notes-container'))
        $.ajax({
            url: orderUrl,
            type: 'POST',
            data: {
                '_token': token,
                'data' : {
                    'order_id' : orderId,
                    'note' : $('#order_note').val(),
                    'type' : 'note'
                }
            },
            success: function(data) {
                if (data.status == 1) {
                    triggerNotification(data.message)

                    $('.order-notes-container .notes').prepend(`
                        <div class="order-notes mb-2">
                            <span>${data.note}</span>
                        </div>
                        <div class="date-delete-container">
                            <span class="date">${data.date}</span>
                        </div>
                    `);
                    $('#order_note').val('');
                } else {
                    triggerNotification(data.error)
                }
            },
            error: function() {
                triggerNotification(jsLang('Something went wrong, please try again.'))
            },
            complete: function(data) {
                unblockEverything()
            }
        })
    });

    var deliveryDate = null;
    $("#deliveryDate").on('change', function() {
        deliveryDate = $(this).val();
    });

    // General status
    var oldOrderStatusId = $('#status').val();
    function updateMainStatus() {
        let orderStatusId = $('#status').val();
        let paymentStatus = $('#payment_status').val();

        if (paymentStatus == 'Unpaid' && orderStatusId == finalOrderStatus) {
            $(`#status option[value="${oldOrderStatusId}"]`).prop('selected', true);
            $('#status').siblings('.select2-container').find('.select2-selection__rendered').text($(`#status option[value="${oldOrderStatusId}"]`).text());
            triggerNotification(jsLang('Payment status is unpaid.'))
            finished();
            return false;
        }

        $.ajax({
            url: ADMIN_URL + '/orders/change-status',
            type: 'POST',
            data: {
                '_token': token,
                'data': {
                    'status_id': $("#status").val(),
                    'order_id': orderId,
                }
            },
            success: function(data) {
                if (data.status == 1) {
                    triggerNotification(data.message)
                    oldOrderStatusId = orderStatusId;
                    $(".status").each(function() {
                        if (!$(this).hasClass('delivery') && (changeStatus[$(this).attr('data-id')] == undefined || $('#status').val() == finalOrderStatus)) {
                            $(this).val(orderStatusId);
                        }
                    });
                } else {
                    triggerNotification(data.error)
                }

                if (finalOrderStatus == orderStatusId) {
                    $(this).prop('disabled', true);
                    addClassDelivery();
                    checkAllStatus();
                }
            },
            error: function() {
                triggerNotification(jsLang('Something went wrong, please try again.'))
            },
            complete: function() {
                updateProductStatus()
                finished();
                window.location = currentUrl;
            }
        })
    }

    function updateProductStatus() {
        let paymentStatus = $('#payment_status').val();
        if (paymentStatus == 'Unpaid') {
            for (const key in changeStatus) {
                if (changeStatus[key] == finalOrderStatus) {
                    $(`.status[data-id=${key}]`).find(`option[value=${oldDetailStatus[key]}]`).prop('selected', true);
                    delete changeStatus[key];
                }
            }
        }

        if (Object.keys(changeStatus).length > 0) {
            $.ajax({
                url: ADMIN_URL +'/orders/change-status',
                type: 'POST',
                data: {
                    '_token': token,
                    'data': {
                        'status_ids': changeStatus,
                        'order_id': orderId,
                        'type' : 'detail'
                    }
                },
                success: function() {
                    $(".status").each(function() {
                        if (!$(this).hasClass('delivery') && finalOrderStatus == $(this).val()) {
                            $(this).addClass('delivery');
                            $(this).prop('disabled', true);
                        }
                    });
                },
                complete: function() {
                    assignOldStatus();
                    changeStatus = {};
                    window.location = currentUrl;
                }
            })
        }
    }

    // Delivery date
    function updateDeliveryDate() {
        if (deliveryDate == null) {
            return false;
        }

        blockElement($('.order-delivery-sections-body'));

        $.ajax({
            url: orderUrl,
            type: 'POST',
            data: {
                '_token': token,
                'data': {
                    'order_id' : orderId,
                    'deliveryDate' : deliveryDate,
                    'type' : 'deliveryDate'
                }
            },
            complete: function() {
                unblockEverything();
                deliveryDate = null;
            }
        })
    }

    var orderUpdate = 0;
    $(document).on('click', '#update-order', function(e) {
        if (++orderUpdate > 1) {
            return false;
        }

        $(this).text(jsLang('Updating')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status">`)
        blockElement($('.order-details-body'))
        blockElement($('.order-info-table-container'))
        blockElement($('.download-permission-container'))
        updateDeliveryDate()
        let status = $('#payment_status').val();
        const downloadData = []
        $(".download_data").each(function(i,div) {
            downloadData[i] = $(":input",this).map(function() { // OR your can consider $(":input",this).serializeArray()
                return { [$(this).attr("name")]:$(this).val() }
            }).get()
        })

        let billingData = '';

        if (!$('#billing_address_edit_section').hasClass('display_none')) {
            billingData = $("#billing_address_edit_section")
                .find("input,select")
                .serialize();
            if (!checkBillingAddress()) {
                $('#update-order').text(jsLang('Update'))
                $('#update-order').next().remove();
                orderUpdate = 0;
                return false;
            }
            
        }

        let shippingData = '';

        if (!$('#shipping_address_edit_section').hasClass('display_none')) {
            shippingData = $("#shipping_address_edit_section")
                .find("input,select")
                .serialize();

            if (!checkShippingAddress()) {
                $('#update-order').text(jsLang('Update'))
                $('#update-order').next().remove();
                orderUpdate = 0;
                return false;
            }
        }

        $.ajax({
            url: orderUrl,
            type: 'POST',
            data: {
                '_token': token,
                'data': {
                    'order_id': orderId,
                    'payment_status': status,
                    'user_id': $('#user_id').val(),
                    'order_date': $('#order_date').val(),
                    'download_data' : JSON.stringify(downloadData),
                    'billing_data' : billingData,
                    'shipping_data' : shippingData,
                    'type': 'general'
                }
            },
            success: function(data) {
                if (oldOrderStatusId == $('#status').val()) {
                    if (data.status == 1) {
                        triggerNotification(data.message)
                    } else {
                        triggerNotification(data.error)
                    }
                }
            },
            error: function() {
                triggerNotification(jsLang('Something went wrong, please try again.'))
            },
            complete: function() {
                if (oldOrderStatusId == $('#status').val()) {
                    updateProductStatus();
                    finished();
                } else {
                    updateMainStatus()
                }
                window.location = currentUrl;
            }
        })
    })

    // Order Actions
    var orderActionCount = 0;
    $(document).on('click', '#order_action_btn', function(e) {
        let actionVal = $('#orderAction').val();
        if(!actionVal || ++orderActionCount > 1) {
            return false;
        }

        // Add loader
        $(this).html(`<div class="order-action-loader spinner-border spinner-border-sm">`)

        let data = {
            'order_id' : orderId,
            'action_val' : actionVal,
            'type' : 'orderAction'
        };
        $.ajax({
            type: "POST",
            url: orderUrl,
            data: {
                "_token": token,
                data: data,
            },
            success: function (data) {
                if (data.status == 1) {
                    triggerNotification(data.message)
                } else if(typeof (data.error != undefined)) {
                    triggerNotification(data.error)
                } else {
                    triggerNotification(jsLang('Something went wrong, please try again.'))
                }
            },
            complete: function() {
                // Remove loader
                $('#order_action_btn').html(`<i class="feather icon-chevron-right fa-2x"></i>`)
                orderActionCount = 0;
            }
        });
    });

    $(".select-user").select2({
        ajax: {
            url: ADMIN_URL + '/find-users-with-ajax',
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                let results = data.data;
                return {
                    results: results
                };
            },
            cache: true,
        },
        placeholder: jsLang("Search for users by name."),
        minimumInputLength: 3,
    });

}

if ($('.main-body .page-wrapper').find('#invoice-view-container').length || $('.main-body .page-wrapper').find('#vendor-order-view-container').length) {

    $(document).on('click', '.download_copy_link', function(e) {
        // Get the text field
        var copyText = $(this).attr('data-link');

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText);
        triggerNotification(jsLang('link copied'))
    });

    $(document).on('click', '.revoke_access', function(e) {
        let file_id = $(this).attr('data-id');
        let html = $(this);
        let txtHtml = $(this).text();
        $(this).text(jsLang('Updating')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status">`)
        blockElement($('.download-permission-container'))
        $.ajax({
            url: orderUrl,
            type: 'POST',
            data: {
                '_token': token,
                'data': {
                    'order_id': orderId,
                    'file_id': file_id,
                    'type': 'download'
                }
            },
            success: function(data) {
                if (data.status == 1) {
                    triggerNotification(data.message)
                } else {
                    triggerNotification(data.error)
                }
            },
            error: function() {
                triggerNotification(jsLang('Something went wrong, please try again.'))
            },
            complete: function() {
                $('#downloadData-'+file_id).remove();
                unblockEverything();
                html.text(txtHtml);
            }
        })

    });

    $("#search_products").select2({
        ajax: {
            url: ADMIN_URL + '/find-downloadable-products-with-ajax',
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                let results = data.data;
                return {
                    results: results
                };
            },
            cache: true,
        },
        placeholder: jsLang("Search for a downloadable product"),
        minimumInputLength: 3,
    });

    $(document).on('click', '#grant_access', function(e) {
        let txtHtml = $(this).text();
        let element = $(this);
        $(this).text(jsLang('Updating')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status">`)
        blockElement($('.download-permission-container'))
        $.ajax({
            url: ADMIN_URL + '/grant-access-with-ajax',
            type: "POST",
            data: {
                "_token": token,
                product_ids: $('select[name="grant_access[]"]').map(function(){return $(this).val();}).get(),
                order_id: orderId
            },
            dataType: "json",
            success: function (data) {
                if (data.status == 1) {
                    let html = ``;
                    $.each(data.data, function (i, v) {
                        if (parseInt(v.is_accessible) == 1 && typeof vendorId != 'undefined' && vendorId == v.vendor_id || parseInt(v.is_accessible) == 1 && orderView == 'admin') {
                            html += `
                                <div class="col-sm-12 download_data" id="downloadData-${ v.id }">
                                    <div class="row px-3">
                                        <div class="col-md-2 mt-2 mt-md-0">
                                            <span>${ jsLang('Download limit') }</span>
                                            <div class="d-flex">
                                                <input type="hidden" name="id" value="${ v.id }">
                                                <input value="${ v.download_limit }" name="download_limit" class="form-control inputFieldDesign" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-2 mt-md-0">
                                            <span>${ jsLang('Download expiry') }</span>
                                            <div class="d-flex">
                                              <input value="${ v.download_expiry }" name="download_expiry" class="form-control inputFieldDesign" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <span>${ jsLang('Customer download link') }</span>
                                            <div class="d-flex">
                                              <a href="javascript:void(0)" class="download_copy_link btn-default p-1" data-link = "${ v.link }">${ jsLang("Copy Link") }</a>
                                            </div>
                                        </div>
                                        <input type="hidden" name="link" value="${ v.link }">
                                        <input type="hidden" name="download_times" value="${ v.download_times }">
                                        <input type="hidden" name="is_accessible" value="${ v.is_accessible }">
                                        <input type="hidden" name="vendor_id" value="${ v.vendor_id }">
                                        <input type="hidden" name="name" value="${ v.name }">
                                        <input type="hidden" name="f_name" value="${ v.f_name }">
                                        <div class="col-md-3 mt-2 mt-md-0">
                                            <span>${ jsLang('Access') }</span>
                                            <div class="d-flex">
                                                <a href="javascript:void(0)" class="revoke_access btn-default p-2" data-id="${ v.id }">${ jsLang('Revoke access') }</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-2 mt-md-0">
                                            <span>${ jsLang('Downloaded') }</span>
                                            <div class="d-flex">
                                                ${ v.download_times + " " + jsLang('Times') }
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                        }
                    });

                    $('#download_div').html(html);
                }
            },
            error: function() {
                triggerNotification(jsLang('Something went wrong, please try again.'))
            },
            complete: function() {
                unblockEverything();
                element.text(txtHtml);
                $('#search_products').empty();
            }
        });
    });
}

// Vendor Section
if ($('.main-body .page-wrapper').find('#vendor-order-view-container').length) {
    $("#updateNote").on('click', function() {
        blockElement($(this).closest('.order-notes-container'))
        $.ajax({
            url: ADMIN_URL + '/store-note',
            type: 'POST',
            data: {
                '_token': token,
                'data' : {
                    'order_id' : orderId,
                    'note' : $('#order_note').val()
                }
            },
            success: function(data) {
                if (data.status == 1) {
                    triggerNotification(data.message)

                    $('.order-notes-container .notes').prepend(`
                        <div class="order-notes mb-2">
                            <span>${data.note}</span>
                        </div>
                        <div class="date-delete-container">
                            <span class="date">${data.date}</span>
                        </div>
                    `);
                    $('#order_note').val('');
                } else {
                    triggerNotification(data.error)
                }
            },
            error: function() {
                triggerNotification(jsLang('Something went wrong, please try again.'))
            },
            complete: function(data) {
                unblockEverything()
            }
        })
    });

    // Order Actions
    var orderActionCount = 0;
    $(document).on('click', '#order_action_btn', function(e) {
        let actionVal = $('#orderAction').val();
        if(!actionVal || ++orderActionCount > 1) {
            return false;
        }

        // Add loader
        $(this).html(`<div class="order-action-loader spinner-border spinner-border-sm">`)

        let data = {
            'order_id' : orderId,
            'action_val' : actionVal,
            'type' : 'orderAction'
        };
        $.ajax({
            type: "POST",
            url: ADMIN_URL + '/order/actions',
            data: {
                "_token": token,
                data: data,
            },
            success: function (data) {
                if (data.status == 1) {
                    triggerNotification(data.message)
                } else if(typeof (data.error != undefined)) {
                    triggerNotification(data.error)
                } else {
                    triggerNotification(jsLang('Something went wrong, please try again.'))
                }
            },
            complete: function() {
                // Remove loader
                $('#order_action_btn').html(`<i class="feather icon-chevron-right fa-2x"></i>`)
                orderActionCount = 0;
            }
        });
    });

    var orderUpdate = 0;
    $('#update-order').on('click', function() {

        if (++orderUpdate > 1) {
            return false;
        }

        const downloadData = []
        $(".download_data").each(function(i,div) {
            downloadData[i] = $(":input",this).map(function() { // OR your can consider $(":input",this).serializeArray()
                return { [$(this).attr("name")]:$(this).val() }
            }).get()
        })

        let billingData = '';

        if (!$('#billing_address_edit_section').hasClass('display_none')) {
            billingData = $("#billing_address_edit_section")
                .find("input,select")
                .serialize();

            if (!checkBillingAddress()) {
                $('#update-order').text(jsLang('Update'))
                $('#update-order').next().remove();
                orderUpdate = 0;
                return false;
            }
        }

        let shippingData = '';

        if (!$('#shipping_address_edit_section').hasClass('display_none')) {
            shippingData = $("#shipping_address_edit_section")
                .find("input,select")
                .serialize();
            
            if (!checkShippingAddress()) {
                $('#update-order').text(jsLang('Update'))
                $('#update-order').next().remove();
                orderUpdate = 0;
                return false;
            }
        }

        $(this).text(jsLang('Updating')).append(`<div class="spinner-border spinner-border-sm ml-2" role="status">`)
        blockElement($('.order-info-table-container'));
        blockElement($('.download-permission-container'));

        var unpaidFinalStatus = 0;
        if (paymentStatus == 'Unpaid') {
            for (const key in changeStatus) {
                if (changeStatus[key] == finalOrderStatus) {
                    $(`.status[data-id=${key}]`).find(`option[value=${oldDetailStatus[key]}]`).prop('selected', true);
                    delete changeStatus[key];
                    ++unpaidFinalStatus;
                }
            }
        }
        if (unpaidFinalStatus > 0) {
            triggerNotification(jsLang('Please pay first in order to reach the final status.'));
            finished();
            return false;
        }

        $.ajax({
            url: ADMIN_URL +'/orders/change-status',
            type: 'POST',
            data: {
                '_token': token,
                'data': {
                    'status_ids': changeStatus,
                    'id': orderId,
                    'type' : 'detail',
                    'download_data' : JSON.stringify(downloadData),
                    'billing_data' : billingData,
                    'shipping_data' : shippingData,
                }
            },
            success: function(data) {
                $(".status").each(function() {
                    if (!$(this).hasClass('delivery') && finalOrderStatus == $(this).val()) {
                        $(this).addClass('delivery');
                        $(this).prop('disabled', true);
                    }
                });
                triggerNotification(data.message)
            },
            complete: function() {
                assignOldStatus();
                changeStatus = {};
                finished();
                window.location = currentUrl;
            }
        })
    })

}

$(".select-provider").select2({
    ajax: {
        url: GLOBAL_URL + '/find-shipping-providers',
        dataType: "json",
        delay: 250,
        data: function (params) {
            return {
                q: params.term, // search term
                page: params.page,
            };
        },
        processResults: function (data, params) {
            
            data.unshift({ id: '0', name: 'Custom Provider', image: customProviderImage });

            var option = $(".select-provider").find('option').eq(1);
            if (option.length) {
                data.push({ id: option.val(), name: option.text(), image: option.attr("data-image") });
            }
            return {
                results: data
            };
        },
        cache: true,
    },
    placeholder: jsLang("Search for provider by name."),
    allowClear: true,
    minimumInputLength: 1,
    language: {
        inputTooShort: function (args) {
          return jsLang("Start typing to search...");
        },
        noResults: function () {
          return jsLang("No results found");
        },
        searching: function () {
          return jsLang("Searching...");
        }
    },
    templateSelection: function (data) {
        if (!data.id) {
            return jsLang("Start typing to search...");
        }
        
        if (data.text) {
            data.name = data.text;
            data.image = data.image || $(".select-provider").find('option:first').attr("data-image");
        }
        
        return $("<div><img class='rounded'  src='" + data.image + "' width='25' height='25'/><span class='ms-2 fw-bold'> " + data.name + "</span></div>");
    },
    templateResult: function (data) {
        if (!data.id || !data.image) {
            return;
        }
        
        return $(`<div class="d-flex align-items-center">
                <div>
                    <img class="rounded" width="25" height="25" src="${data.image}">
                </div>
                <div class="ms-3">
                    <div><strong>${data.name}</strong></div>
                </div>
            </div>`);
    }
});

  // Edit shipping tracking information
  $(document).on('click', '.shipping-track-info', function () {
    //Reset
    $("#track-shipping").find('input:not([type="hidden"])').each(function() {
        $(this).val('');
    });
    $("#track-shipping").find('select').val(null).trigger('change');
    unblockEverything();
    //Reset

    var shipping_provider_id = $(this).data('shipping_provider_id');
    var shipping_provider_logo = $(this).data('shipping_provider_logo');
    var provider_name = $(this).data('provider_name');
    var order_id = $(this).data('order_id');
    var product_id = $(this).data('product_id');
    var tracking_link = $(this).data('tracking_link');
    var tracking_no = $(this).data('tracking_no');
    var order_shipped_date = $(this).data('order_shipped_date');

    const selectElement = $('#shipping_provider_id');

    // Clear previous options before adding a new one
    selectElement.empty();

    const option = $('<option>', {
    value: shipping_provider_id,
    'data-image': shipping_provider_logo,
    text: provider_name
    });

    selectElement.append(option);
    selectElement.val(shipping_provider_id);
    selectElement.trigger('change');

    $("#track-shipping").find("#provider_name").val(provider_name);
    $("#track-shipping").find("#tracking_number").val(tracking_no);
    $("#track-shipping").find("#tracking_link").val(tracking_link);
    $("#track-shipping").find("#order_shipped_date").val(order_shipped_date);
    $("#track-shipping").find("#order_id").val(order_id);
    $("#track-shipping").find("#product_id").val(product_id);
    // Show the modal
    $('#track-shipping').modal('show');
});

$("#generate_track_link").on('click',function(){

    blockElement($(this).closest('.order-shipment-tracking-container'))

    let tracking_link = $('#tracking_base_url').val();
    let tracking_no = $('#tracking_number').val();
    

    // if(tracking_no == ''){
    //     triggerNotification(jsLang('Tracking number field is required'));
    // }
    
    if(tracking_link == ''){
        triggerNotification(jsLang('Tracking link field is required'))
    }

    if(tracking_link.includes('%number%')) {
        tracking_link = tracking_link.replace('%number%', tracking_no);
    } else if (tracking_no) {
        tracking_link = tracking_link + tracking_no;
    }

    $('#tracking_link').val(tracking_link);
    $('#preview_link').attr('href', tracking_link);
    
    unblockEverything()
});

$("#updateOrderTrack").on('click',function(){
    var $this = $(this)
    $(this).text(jsLang('Updating')).append(`<div class="spinner-border spinner-border-sm ml-2">`)
    blockElement($(this).closest('.order-shipment-tracking-container'))
    $.ajax({
        url: orderUrl,
        type: 'POST',
        data: {
            '_token': token,
            'data' : {
                'order_id' : orderId,
                'product_id': $('#product_id').val(),
                'shipping_provider_id' : $('#shipping_provider_id').val(),
                'provider_name': $('#provider_name').val(),
                'tracking_no': $('#tracking_number').val(),
                'tracking_link': $('#tracking_link').val(),
                'order_shipped_date': $('#order_shipped_date').val(),
                'track_type': $('#track_type').val(),
                'type' : 'shipmentTracking'
            }
        },
        success: function(data) {
            if (data.status == 1) {
                triggerNotification(data.message)
                window.location.reload(); 
            } else {
                $this.text(jsLang('Save Tracking')).append(`<div class="spinner-border spinner-border-sm ml-2">`)
                triggerNotification(data.error)
            }
        },
        error: function() {
            $this.text(jsLang('Save Tracking')).append(`<div class="spinner-border spinner-border-sm ml-2">`)
            triggerNotification(jsLang('Something went wrong, please try again.'))
        },
        complete: function(data) {
            unblockEverything();
        }
    });
});

$(document).ready(function() {  

    $("#shipping_provider_id").on('change',function(){
    blockElement($(this).closest('.order-shipment-tracking-container'))
    $("#tracking_link").val("");
    $("#tracking_number").val("");
    $("#tracking_base_url").val("");
    $("#order_shipped_date").val("");
    
    let shippingProviderId = $('#shipping_provider_id').val();
    
    if(shippingProviderId == 0 && shippingProviderId != '') {
        $("#custom_provider_name").removeClass('d-none');
        $("#generate_track_link").addClass('d-none');
        $("#provider_name").val("");
        unblockEverything()
        return;
    }else{
        $("#provider_name").val($('#shipping_provider_id option:selected').text());
        $("#generate_track_link").removeClass('d-none');
        unblockEverything()
    }

    $("#custom_provider_name").addClass('d-none');

    if(shippingProviderId){
        $.ajax({
            url: GLOBAL_URL + '/shipping/provider/'+shippingProviderId,
            type: 'GET',
            success: function(data){
                if (data.status == 1) {
                    $("#provider_name").val(data.content.name);
                    $("#tracking_link").val(data.content.tracking_base_url);
                    $("#tracking_base_url").val(data.content.tracking_base_url);
                    if(data.track_method == 'Post'){
                        $("#generate_track_link").addClass("d-none");
                    }else{
                        $("#generate_track_link").trigger('click');
                    }
                } else {
                    triggerNotification(data.error)
                }
            },
            error: function() {
                triggerNotification(jsLang('Something went wrong, please try again.'))
            },
            complete: function(data) {
                unblockEverything()
            }
        });
    }
    });
});

//Order shipped date range picker default is empty
$('#order_shipped_date').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    autoUpdateInput: false, 
    minDate: moment().startOf('day'), 
    drops: 'up',
    locale: {
        format: 'YYYY-MM-DD' 
    }
});

$('#order_shipped_date').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD'));
});

function checkBillingAddress()
{
    let billFlag = true;
    
    $.each($('.has_require'), function (){
        if (!$(this).val()) {
            if (!$(this).hasClass('error_tag')) {
                $(this).addClass('error_tag');
                $(this).parent().append(`<label id="title-error" class="error error_msg" for="title" style="">${jsLang('This field is required.')}</label>`)
            }
            billFlag = false;
        } else {
            $(this).removeClass('error_tag');
            $(this).parent().find('.error_msg').remove();
        }

    });

    let checkType = true;

    if ($('.checked_require').length == 2) {
        if (!$('#radio-w-infill-1').prop('checked') == true && !$('#radio-w-infill-2').prop('checked') == true) {
            checkType = false;
        }
        
        if (billFlag == true) {
            billFlag = checkType;
        }

        if (!$('#radio-w-infill-1').parent().find('.error_msg').length && !$('#radio-w-infill-1').prop('checked') == true && !$('#radio-w-infill-2').prop('checked') == true) {
            $('#radio-w-infill-1').parent().append(`<label id="title-error" class="error error_msg" for="title" style="">${jsLang('This field is required.')}</label>`)
        } else if ($('#radio-w-infill-1').prop('checked') == true || $('#radio-w-infill-2').prop('checked') == true) {
            $('#radio-w-infill-1').parent().find('.error_msg').remove();
        }
    }
    
    return billFlag;
}

function checkShippingAddress()
{
    let shipFlag = true;

    $.each($('.shipping_has_require'), function () {
        if (!$(this).val()) {
            if (!$(this).hasClass('error_tag')) {
                $(this).addClass('error_tag');
                $(this).parent().append(`<label id="title-error" class="error error_msg" for="title" style="">${jsLang('This field is required.')}</label>`)
            }
            shipFlag = false;
        } else {
            $(this).removeClass('error_tag');
            $(this).parent().find('.error_msg').remove();
        }

    });

    let checkType = true;
    if ($('.shipping_checked_require').length == 2) {
        if (!$('#shipping_radio-w-infill-1').prop('checked') == true && !$('#shipping_radio-w-infill-2').prop('checked') == true) {
            checkType = false;
        }

        if (shipFlag == true) {
            shipFlag = checkType;
        }

        if (!$('#shipping_radio-w-infill-1').parent().find('.error_msg').length && !$('#shipping_radio-w-infill-1').prop('checked') == true && !$('#shipping_radio-w-infill-2').prop('checked') == true) {
            $('#shipping_radio-w-infill-1').parent().append(`<label id="title-error" class="error error_msg" for="title" style="">${jsLang('This field is required.')}</label>`)
        } else if ($('#shipping_radio-w-infill-1').prop('checked') == true || $('#shipping_radio-w-infill-2').prop('checked') == true) {
            $('#shipping_radio-w-infill-1').parent().find('.error_msg').remove();
        }
    }

    return shipFlag;
}

$(document).on("click", "#payment-link", copyURL);

function copyURL() {
    var copyText = $(this).attr('data-route');

    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText);
    triggerNotification(jsLang('link copied'));
}

$(".select2-vendor").select2({
    ajax: {
        url: ADMIN_URL + '/find-vendors-with-ajax',
        dataType: "json",
        delay: 250,
        data: function (params) {
            return {
                q: params.term, // search term
                page: params.page,
            };
        },
        processResults: function (data, params) {
            let results = data.data;
            
            return {
                results: results
            };
        },
        cache: true,
        allowClear: true
    },
    placeholder: jsLang("Search for vendors by name."),
    minimumInputLength: 3,
    allowClear: true,
});

if (!ADMIN_URL.includes('admin')) {
    ADMIN_URL = ADMIN_URL + '/admin';
}

$(".select2-user").select2({
    ajax: {
        url: ADMIN_URL + '/find-users-with-ajax',
        dataType: "json",
        delay: 250,
        data: function (params) {
            return {
                q: params.term, // search term
                page: params.page,
            };
        },
        processResults: function (data, params) {
            let results = data.data;
            return {
                results: results
            };
        },
        cache: true,
    },
    placeholder: jsLang("Search for users by name."),
    minimumInputLength: 3,
    allowClear: true,
});

