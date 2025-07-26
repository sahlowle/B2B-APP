'use strict';
if ($('.main-body .page-wrapper').find('#transfer-add-container').length || $('.main-body .page-wrapper').find('#transfer-edit-container').length) {

    var stack = [];

    if ($('.main-body .page-wrapper').find('#transfer-add-container').length) {
        $('input[name="arrival_date"]').daterangepicker(dateSingleConfig());
    }

    if ($('.main-body .page-wrapper').find('#transfer-edit-container').length) {
        $('input[name="arrival_date"]').daterangepicker(dateSingleConfig($('input[name="arrival_date"]').val()));
        stack = JSON.parse(editStack);
    }

    function in_array(search, array) {
        var i;
        for (i = 0; i < array.length; i++) {
            if(array[i] ==search ) {
                return true;
            }
        }
        return false;
    }

    function checkProductTableData()
    {
        if ($('.closeRow').length == 0) {
            $('#product-table').addClass('display_none');
        } else {
            $('#product-table').removeClass('display_none');
        }
    }

    function autoCompleteSource(request, response, url) {

        if ($('#vendor_id').val() == '') {
            $('#error_message').text(jsLang('Please select vendor!'));
            return false;
        } else if ($('#from_location_id').val() == '') {
            $('#error_message').text(jsLang('Please select origin!'));
            return false;
        } else {
            $('#error_message').text('');
        }

        $.ajax({
            url: url,
            dataType: "json",
            type: "POST",
            data: {
                _token: token,
                search: request.term,
                vendorId : $('#vendor_id').val(),
                fromLocationId : $('#from_location_id').val(),
            },
            success: function (data) {
                if (data.status == 1) {
                    var data = data.products;
                    $('#no_div').css('display', 'none');
                    response($.map(data, function (products) {
                        return {
                            id: products.id,
                            value: products.name,
                            qty: products.total_quantity,
                            sku: products.sku
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

    $("#search").autocomplete({
        delay: 500,
        position: {my: "left top", at: "left bottom", collision: "flip"},
        source: function (request, response) {
            autoCompleteSource(request, response, SITE_URL + '/inventory/transfer/product-search');
        },
        select: function (event, ui) {
            var e = ui.item;
            if (e.id) {
                if (!in_array(e.id, stack)) {
                    stack[e.id] = e.id;
                    var new_row = `<tbody id="rowId-${rowNo}" class="transfer_products">
                          <input type="hidden" name="product_id[]" value="${e.id}">
                          <tr class="itemRow rowNo-${rowNo}" id="productId-${e.id}"  data-row-no="${rowNo}">
                              <td class="pl-1">
                                  ${e.value}
                              </td>
                              
                              <td class="sku">
                                  <input id="sku_${rowNo}" class="form-control text-center" type="text" readonly value="${e.sku}">
                              </td>
                              
                              <td class="productQty">
                                  <input name="product_qty[]" id="product_qty_${rowNo}" class="inputQty form-control text-center" type="number" value="1" data-rowId = ${rowNo} max="${e.qty}">
                              </td>
                              <td class="text-center padding_top_15px">
                                  <a href="javascript:void(0)" class="closeRow" data-row-id="${rowNo}" data-id="${e.id}"><i class="feather icon-trash"></i></a>
                              </td>
                          </tr>
                          
                      </tbody>`;
                    $('#product-table').append(new_row);
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

    locationSelect2Define();

    function locationSelect2Define()
    {
        $(".location").select2({
            ajax: {
                url: SITE_URL + '/inventory/find-location-with-ajax',
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        vendorId: $('#vendor_id').val(),
                        from_location_id : $('#from_location_id').val(),
                        to_location_id : $('#to_location_id').val()
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
            placeholder: jsLang("Search for location by name."),

            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 3,
            allowClear:true
        });
    }

    if ($('.main-body .page-wrapper').find('#transfer-add-container').length) {
        $("#vendor_id").select2({
            ajax: {
                url: SITE_URL + '/inventory/find-vendor-with-ajax',
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
            placeholder: jsLang("Search for vendor by name."),
            minimumInputLength: 3,
        });
    }

    $(document).on('keyup change', '.inputQty', function() {
        let maxVal = parseFloat($(this).attr('max'));

        $(this).val(parseInt($(this).val()));
        
        if (parseFloat($(this).val()) > maxVal) {
            $(this).val(maxVal);
        }
        
        if (parseFloat($(this).val()) < 0) {
            $(this).val(0);
        }
    });

    $(document).on("click", ".closeRow", function (e) {
        e.preventDefault();
        let selector = '#rowId-'+$(this).attr("data-row-id");
        let pId= $(this).attr('data-id');
        let i = 0;
        $(selector).remove();

        for (i = 0; i < stack.length; i++) {
            if(stack[i] == pId ) {
                stack.splice(i, 1, 0);
            }
        }
        
        checkProductTableData();
    });

    $('#vendor_id').on('change', function() {
        $('.transfer_products').remove();
        stack = [];
        $('#from_location_id').val(null).trigger('change');
        checkProductTableData();
    });

    $('#from_location_id').on('change', function() {
        $('.transfer_products').remove();
        stack = [];
        checkProductTableData();
    });
}
