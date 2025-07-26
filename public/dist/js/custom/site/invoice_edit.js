"use strict";

let loader = `<option value="">${jsLang('Loading')}...</option>`;
let selectCity = `<option value="">${jsLang('Select City')}</option>`;
let selectState = `<option value="">${jsLang('Select State')}</option>`;
let errorMsg = jsLang(':x is not available.');
var stack = [];
var rowNo = 0;

if ($('.shipping-address-form').find('#ShippingaddressForm').length) {
    $.ajax({
        url: SITE_URL + "/geo-locale/countries",
        type: "GET",
        dataType: 'json',
        beforeSend: function() {
            $('#shipping_country').html(loader);
            $('#shipping_country').attr('disabled','true');
        },
        success: function(result) {
            $('#shipping_country').html('<option value="">' + jsLang('Select Country') + '</option>');
            $.each(result, function(key, value) {
                $("#shipping_country").append(`'<option  ${value.code==oldShipCountry?'Selected': ''} data-country="${value.code}" value="${ value
                    .code}">${value.name}</option>'`);
            });
            $("#shipping_country").removeAttr("disabled");
        }
    });
}

if (oldShipState != "null") {
    getShipState(oldShipCountry);
}
if (oldShipCity != "null") {
    getShipCity(oldShipState,oldShipCountry);
}


$('#shipping_country').on('change', function() {
    let str = $(this).find(':selected').html();
    oldShipCountry = "null";

    if (str.length > 0) {
        let selector = this.closest('.validSelect');
        selector.querySelector('.addressSelect').setCustomValidity("");
        if (selector.querySelector('.error')) {
            selector.querySelector('.error').remove();
        }
    }
    getShipState($('#shipping_country').find(':selected').attr('data-country'));
});

function getShipState( country_code ) {

    if (country_code) {
        $("#shipping_state").html('');
        if (oldShipCity == "null") {
            $('#shipping_city').html(selectCity);
        }
        $.ajax({
            url: SITE_URL + "/geo-locale/countries/" + country_code + "/states",
            type: "GET",
            dataType: 'json',
            beforeSend: function() {
                $('#shipping_state').attr('disabled','true');
                $('#shipping_state').html(loader);
            },
            success: function(result) {
                $('#shipping_state').html(selectState);
                $.each(result.data, function(key, value) {
                    $("#shipping_state").append(`'<option ${value.code==oldShipState?'Selected': ''} data-state="${value.code}" value="${value.code}">${value.name}</option>'`);
                });
                $("#shipping_state").removeAttr("disabled");
                if (result.length <= 0 && result.data.length <= 0) {
                    errorMsg = errorMsg.replace(":x", 'State');
                    $('#shipping_state').html(`<option value="">${errorMsg}</option>`);
                }
            }
        });
    } else {

        $('#shipping_state').html(selectState);
        $('#shipping_city').html(selectCity);

    }
}

$('#shipping_state').on('change', function() {
    let str = $(this).find(':selected').html();

    if (str.length > 0) {
        let selector = this.closest('.validSelect');
        selector.querySelector('.addressSelect').setCustomValidity("");
        if (selector.querySelector('.error')) {
            selector.querySelector('.error').remove();
        }
    }
    getShipCity($('#shipping_state').find(':selected').attr('data-state'), $('#shipping_country').find(':selected').attr('data-country'));

});

function getShipCity( siso, ciso) {

    if (siso && ciso) {
        $("#shipping_city").html('');
        $.ajax({
            url: SITE_URL + "/geo-locale/countries/" + ciso + "/states/" + siso +
                "/cities",
            type: "GET",
            dataType: 'json',
            beforeSend: function() {
                $('#shipping_city').html(loader);
                $('#shipping_city').attr('disabled','true');
            },
            success: function(res) {
                $('#shipping_city').html(selectCity);
                $.each(res.data, function(key, value) {
                    $("#shipping_city").append(`<option ${value.name == oldShipCity ? 'Selected': ''} value="${value.name}">${value.name}</option>`);
                });
                $("#shipping_city").removeAttr("disabled");
                if (res.length <= 0 && res.data.length <= 0) {
                    errorMsg = errorMsg.replace(":x", 'City');
                    $('#shipping_city').html(`<option value="">${errorMsg}</option>`);
                }
            }
        });
    } else {
        $('#shipping_city').html(selectCity);
    }
}
$('#shipping_city').on('change', function() {
    let str = $(this).find(':selected').html();

    if (str.length > 0) {
        let selector = this.closest('.validSelect');
        selector.querySelector('.addressSelect').setCustomValidity("");
        if (selector.querySelector('.error')) {
            selector.querySelector('.error').remove();
        }
    }
});

$('#billing_address_edit').on('click', function() {
    if (!$('#billing_address').hasClass('display_none')) {
        $('#billing_address').addClass('display_none');
        
        $('#billing_address_edit').html('<p class="text-danger">Cancel</p>');
        
    } else {
        $('#billing_address').removeClass('display_none');
        
        $('#billing_address_edit').html('<i class="feather icon-edit-1"></i>');
    }

    if (!$('#billing_address_edit_section').hasClass('display_none')) {
        $('#billing_address_edit_section').addClass('display_none');
        $('#load_billing_address').addClass('display_none');
    } else {
        $('#billing_address_edit_section').removeClass('display_none');
        $('#load_billing_address').removeClass('display_none');
    }
    
});

$('#shipping_address_edit').on('click', function() {
    if (!$('#shipping_address').hasClass('display_none')) {
        $('#shipping_address').addClass('display_none');

        $('#shipping_address_edit').html('<p class="text-danger">Cancel</p>');
    } else {
        $('#shipping_address').removeClass('display_none');

        $('#shipping_address_edit').html('<i class="feather icon-edit-1"></i>');
    }

    if (!$('#shipping_address_edit_section').hasClass('display_none')) {
        $('#shipping_address_edit_section').addClass('display_none');
        $('#copy_billing_address').addClass('display_none');
    } else {
        $('#copy_billing_address').removeClass('display_none');
        $('#shipping_address_edit_section').removeClass('display_none');
    }

});

$('#copy_billing_address').on('click', function() {
    $('#shipping_address_first_name').val($('#first_name').val());
    $('#shipping_address_last_name').val($('#last_name').val());
    $('#shipping_address_phone').val($('#phone').val());
    $('#shipping_address_email').val($('#email').val());
    $('#shipping_address_company_name').val($('#company_name').val());
    $('#shipping_address_address_1').val($('#address_1').val());
    $('#shipping_address_address_2').val($('#address_2').val());
    $('#shipping_country').val($('#country').val()).trigger('change');

    setTimeout(() => {
        $('#shipping_state').val($('#state').val()).trigger('change');
        setTimeout(() => {
            $('#shipping_city').val($('#city').val()).trigger('change');
        }, 1000);
    }, 1000);
   
    $('#shipping_address_zip').val($('#zip').val());

    let typeOfPlace = $("input[name='type_of_place']:checked").val();
    
    if ($('#shipping_radio-w-infill-1').val() == typeOfPlace) {
        $("#shipping_radio-w-infill-1").prop("checked", true);
    }

    if ($('#shipping_radio-w-infill-2').val() == typeOfPlace) {
        $("#shipping_radio-w-infill-2").prop("checked", true);
    }
    
});

function isEmptyObject(value) {
    if (value == null) {
        // null or undefined
        return false;
    }

    if (typeof value !== 'object') {
        // boolean, number, string, function, etc.
        return false;
    }

    const proto = Object.getPrototypeOf(value);

    // consider `Object.create(null)`, commonly used as a safe map
    // before `Map` support, an empty object as well as `{}`
    if (proto !== null && proto !== Object.prototype) {
        return false;
    }

    return isEmpty(value);
}

function isEmpty(obj) {
    for (const prop in obj) {
        if (Object.hasOwn(obj, prop)) {
            return false;
        }
    }

    return true;
}

$('#load_billing_address').on('click', function() {
$.ajax({
        url: userAddressUrl,
        type: 'POST',
        data: {
            '_token': token,
            'user_id': $('#user_id').val()
        },
        success: function(data) {
           if (!isEmptyObject(data)) {
               $('#first_name').val(data.first_name);
               $('#last_name').val(data.last_name);
               $('#phone').val(data.phone);
               $('#email').val(data.email);
               $('#company_name').val(data.company_name);
               $('#address_1').val(data.address_1);
               $('#address_2').val(data.address_2);

               $('#country').val(data.country).trigger('change');

               setTimeout(() => {
                   $('#state').val(data.state).trigger('change');
                   setTimeout(() => {
                       $('#city').append(`<option value="${data.city}" selected>${data.city}</option>`).trigger('change');
                   }, 1000);
               }, 1000);

               $('#zip').val(data.zip);
               $('#type_of_place').val(data.type_of_place).trigger('change');

               let typeOfPlace = data.type_of_place;

               if ($('#radio-w-infill-1').val() == typeOfPlace) {
                   $("#radio-w-infill-1").prop("checked", true);
               }

               if ($('#radio-w-infill-2').val() == typeOfPlace) {
                   $("#radio-w-infill-2").prop("checked", true);
               }
           } else {
               triggerNotification(jsLang('Address not found.'));
           }
            
        },
        error: function() {

            $(".notification-msg-bar").find(".notification-msg").html(jsLang('Something went wrong, please try again.'));
            $(".notification-msg-bar").removeClass("smoothly-hide");
            setTimeout(() => {
                $(".notification-msg-bar").addClass("smoothly-hide"),
                    $(".notification-msg-bar").find(".notification-msg").html("");
            }, 1500);
        },
    });
});

$(document).on('click', '#add_item', function() {
    $('#custom_item_btn').addClass('display_none');
    $('#custom_item_list').removeClass('display_none');
});



function autoCompleteSource(request, response, url) {
    $.ajax({
        url: url,
        dataType: "json",
        type: "POST",
        data: {
            _token: token,
            search: request.term,
            vendorId : $('#vendor_id').val()
        },
        success: function (data) {
            if (data.status == 1) {
                var data = data.products;
                $('#no_div').css('display', 'none');
                response($.map(data, function (products) {
                    return {
                        id: products.id,
                        value: products.name,
                    }
                }));
            } else {
                $('.ui-menu-item').remove();
                $("#no_div").css('top', $("#search").position().top + 35);
                $("#no_div").css('left', $("#search").position().left);
                $("#no_div").css('width', $("#search").width());
                $("#no_div").css('display', 'block');
            }
            //end
        }
    })
}

/**
 * in_array functionalities
 * @param  string search
 * @param  array array
 * @return void
 */
function in_array(search, array) {
    var i;
    for (i = 0; i < array.length; i++) {
        if(array[i] ==search ) {
            return true;
        }
    }
    return false;
}
$("#search").autocomplete({
    delay: 500,
    position: {my: "left top", at: "left bottom", collision: "flip"},
    source: function (request, response) {
        autoCompleteSource(request, response, ADMIN_URL + '/barcode/product-search');
    },
    select: function (event, ui) {
        var e = ui.item;
        if (e.id) {
            if (!in_array(e.id, stack)) {
                stack[e.id] = e.id;
                var new_row = `<tbody id="rowId-${rowNo}" class="purchase_products">
                          <input type="hidden" name="product_id[]" value="${e.id}">
                          <tr class="itemRow rowNo-${rowNo}" id="productId-${e.id}"  data-row-no="${rowNo}">
                              <td class="pl-1">
                              <input type="hidden" name="product_name[]" value="${e.value}">
                                  ${e.value}
                              </td>
                              
                              <td class="productQty">
                                  <input name="product_qty[]" id="product_qty_${rowNo}" class="inputQty form-control text-center positive-float-number" type="text" value="1" data-rowId = ${rowNo}>
                              </td>
                             
                          </tr>
                          
                      </tbody>`;
                $('#custom-product-table').append(new_row);
                checkProductTableData();
                rowNo++;
            }
            $('#productId-' + e.id).find('.inputQty').trigger("blur");
            return false;
        }
    },
    minLength: 1,
    autoFocus: true
}).autocomplete( "instance" )._renderItem = function( ul, item ) {
    if (!in_array(item.id, stack)) {
        return $( "<li>" )
            .append( "<div>" + item.value + "</div>" )
            .appendTo( ul );
    } else {
        return $( "<li style='pointer-events:none;opacity:0.6;'>" )
            .append( "<div>" + item.value + "</div>" )
            .appendTo( ul );
    }
};

function checkProductTableData()
{
    if ($('.productQty').length == 0) {
        $('#custom-product-table').addClass('display_none');
    } else {
        $('#custom-product-table').removeClass('display_none');
    }
}

$(document).on('click', '#add_product', function() {
    $('.purchase_products').remove();
    checkProductTableData();
});

$(document).on('click', '.delete_product', function() {
    let productId = $(this).attr('data-productId');
    $('#delete_id').val(productId);
    $('#action_type').val('product');
});

$(document).on('click', '.edit_product', function() {
    $(this).addClass('display_none');
    $('#custom_item_btn').addClass('display_none');
    $('#custom_item_list').removeClass('display_none');
    
    let productId = $(this).attr('data-productId');
    let productprice = $(this).attr('data-price');
    let qty = $(this).attr('data-qty');
    let tax = $(this).attr('data-tax');
    
    $('#product_price_'+productId).addClass('display_none');
    $('#product_qty_'+productId).addClass('display_none');
    $('#product_tax_'+productId).addClass('display_none');
    
    $('#product_price_td_'+productId).append(`<input type="text" class="form-control inputFieldDesign mt-2 cancel-able col-md-4 positive-float-number" name="product_price[${productId}]" id="product_price_txt_${productId}" value="${productprice}">`);
    $('#product_qty_td_'+productId).append(`<input type="text" class="form-control inputFieldDesign mt-2 cancel-able col-md-4 positive-float-number" name="product_qty[${productId}]" id="product_qty_txt_${productId}" value="${qty}">`);
    $('#product_tax_td_'+productId).append(`<input type="text" class="form-control inputFieldDesign mt-2 cancel-able col-md-4 positive-float-number" name="product_tax[${productId}]" id="product_qty_txt_${productId}" value="${tax}">`);

    $.each($('.custom_tax_'+productId), function (){
        $(this).addClass('display_none');
        let taxKey = $(this).parent().attr('data-key');
        let amount = $(this).parent().attr('data-amount');
        $(this).parent().append(`<input type="text" class="form-control inputFieldDesign mt-2 cancel-able col-md-4 positive-float-number" name="custom_tax[${productId}][${taxKey}]" value="${amount}">`);
    });
    
});

$(document).on('click', '#cancel_btn', function() {
    $('.cancel-able').remove();
    $('.back_action').removeClass('display_none')

    $('#custom_item_btn').removeClass('display_none');
    $('#custom_item_list').addClass('display_none');
});

$(document).on('click', '#save_custom', function() {
    let editData = '';

    editData = $("#calculations_div")
        .find("input,select")
        .serialize();

    blockElement($('#calculations_div'));

    $.ajax({
        url: orderCustomizeUrl,
        type: 'POST',
        data: {
            '_token': token,
            'order_id': orderId,
            'data': editData,
            'action': 'edit'
        },
        success: function(data) {
            $('#calculations_div').replaceWith(data.viewHtml);
            triggerNotification(jsLang(data.message));
        },
        error: function() {
            triggerNotification(jsLang('Something went wrong, please try again.'));
        },
        complete: function(data) {
            if (data.status == 200) {
                unblockEverything();
            }
        }
    })
});

$(document).on('click', '.edit_fee', function() {
    $(this).addClass('display_none');
    $('#custom_item_btn').addClass('display_none');
    $('#custom_item_list').removeClass('display_none');

    let key = $(this).attr('data-key');
    let amount = $(this).attr('data-amount');
    let tax = $(this).attr('data-tax');
    let label = $(this).attr('data-lbl');
    $('#order_fee_'+key).addClass('display_none');
    $('#order_fee_lbl_'+key).addClass('display_none');
    $('#order_fee_tax_'+key).addClass('display_none');

    $('#order_fee_td_'+key).append(`<input type="text" class="form-control inputFieldDesign mt-0 cancel-able col-md-4 positive-float-number" name="order_fee[${key}]" value="${amount}">`);
    $('#order_fee_tax_td_'+key).append(`<input type="text" class="form-control inputFieldDesign mt-0 cancel-able col-md-4 positive-float-number" name="order_fee_tax[${key}]" value="${tax}">`);
    $('#order_fee_lbl_td_'+key).append(`<input type="text" class="form-control inputFieldDesign mt-0 cancel-able col-md-4" name="order_fee_lbl[${key}]" value="${label}">`);

    $.each($('.custom_fee_'+key), function (){
        $(this).addClass('display_none');
        let feeKey = $(this).parent().attr('data-key');
        let index = $(this).parent().attr('data-index');
        let amount = $(this).parent().attr('data-amount');
        $(this).parent().append(`<input type="text" class="form-control inputFieldDesign mt-0 cancel-able col-md-4 positive-float-number" name="custom_tax_fee[${feeKey}][${index}]" value="${amount}">`);
    });
});

$(document).on('click', '.delete_fee', function() {
    let key = $(this).attr('data-key');
    $('#delete_id').val(key);
    $('#action_type').val('fee');
});

$(document).on('click', '.delete_coupon', function() {
    let key = $(this).attr('data-key');
    $('#delete_id').val(key);
    $('#action_type').val('coupon_delete');
});

$(document).on('submit', 'form', function(e) {
    if ($(this).attr('data-type') != 'refund') {
        e.preventDefault();

        if ($(this).attr('data-type') == 'add_products') {
            if ($('.inputQty').length == 0) {
                triggerNotification(jsLang('Please add product first!'));
                return 0;
            }
        }
        
        var form = this;
        blockElement($('#calculations_div'));
        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: $(form).serialize(),
            success: function(data) {
                $('#calculations_div').replaceWith(data.viewHtml);
                triggerNotification(jsLang(data.message));
                $(form).trigger("reset");
            },
            error: function() {
                triggerNotification(jsLang('Something went wrong, please try again.'));
            },
            complete: function(data) {
                unblockEverything();
                stack = [];
                $('.modal').modal('hide');
            }
        })
    }
});

$(document).on('click', '.delete_custom_tax', function() {
    let key = $(this).attr('data-key');
    $('#delete_id').val(key);
    $('#action_type').val('custom_tax');
})

