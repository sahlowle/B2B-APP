"use strict";

var availableStock = 0;
var isInitiaLize = stockProductId == '' ? true : false;
$('#vendor_id').on('change', function() {
    
    getVendorLocation($(this).val());
    
});

$('#checkbox-p-2').on('click', function() {
    if ($(this).prop('checked') == true && isDisableMultivendor == 1) {
        $('#vendor_id').trigger("change");
    }
});

$('.save-brand-info').on('click', function() {

    if (isInitiaLize && currentRouteName != 'vendor.product.create' && currentRouteName != 'vendor.product.edit') {
        getVendorLocation($('#vendor_id').val());
        isInitiaLize = false;
    }

});

checkInitialStockDiv();

checkVendorUserProduct();

function checkVendorUserProduct()
{
    if (currentRouteName == 'vendor.product.create') {
        getVendorLocation(loginUserVendorId);
        isInitiaLize = false;
    }
}
function checkInitialStockDiv()
{
    $('.initial_stock_div').length > 0 ? $('#save_stock_div').removeClass('display_none') : ''; 
}

function getVendorLocation(vendorId)
{
    $.ajax({
        url: vendorLocationUrl,
        dataType: "json",
        type: "get",
        data: {
            vendor_id : vendorId,
            product_id : stockProductId,
        },
        success: function (data) {
            let html = `<input type="hidden" id="temp_vendor_id" name="temp_vendor_id">`;
            let inc = 1234;
            $('.variation_stock_data').empty();
            if (data.status == '1') {
                $('#stock_msg').text(data.message);

                html += getAdjustStockHtml(data.data['stocks']);
                
                $.each(data.data['locations'], function (i,v) {
                    let uid = 'col_' + inc++;
                    html += `<div class="location-dlt ui-sortable-handle" data-serial="${ i }">
                <form method="POST">
                <div class="d-flex justify-content-between align-items-center border-t h-40p mx-25n px-32p bg-F5 col-attr collapse-header"
                     data-bs-toggle="collapse" href="#${ uid }">
                    <p class="label-title m-0 ml-16n-res font-weight-600 attribute-box-title">${ v.name }</p>
                    <div class="d-flex align-items-center">
                        <svg class="cursor-move mt-0" width="16" height="11" viewBox="0 0 16 11" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="1" fill="#898989" />
                            <rect y="5" width="16" height="1" fill="#898989" />
                            <rect y="10" width="16" height="1" fill="#898989" />
                        </svg>
                        <span
                            class="toggle-btn ml-10p mt-0 d-flex h-20 w-20 align-items-center justify-content-center inactive-sec collapsed"
                            data-bs-toggle="collapse" href="#${ uid }">
                            <svg width="8" height="6" viewBox="0 0 8 6" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.18767 5.90789L7.81732 1.34361C8.24162 0.810056 7.87956 -1.43628e-09 7.21678 -9.33983e-09L0.783223 -8.60592e-08C0.120445 -9.39628e-08 -0.241618 0.810055 0.182683 1.34361L3.81233 5.90789C3.91 6.0307 4.09 6.0307 4.18767 5.90789Z"
                                    fill="#2C2C2C" />
                            </svg>
                        </span>

                    </div>
                </div>
                <div class="collapse" id="${ uid }">
                    <div class="row m-0 px-7 pb-30p">

                            <div class="form-group row mt-3">
                                <label class="col-sm-6 control-label" for="inputEmail3">${ jsLang('Available') }</label>
                                <input type="hidden" value="${v.id}" name="location[${v.id}][id]">
                                <div class="col-sm-6">
                                <input type="number" placeholder="${ jsLang('Available') }" value="0" class="form-control adjust_by inputFieldDesign" name="location[${v.id}][qty]" required oninvalid="this.setCustomValidity('${ jsLang('This field is required.') }')">
                                </div>
                            </div>
                       
                    </div>
                </div>
                </form>
            </div>`;
                });
            $.each(data.data['variations'], function (index,variationData) {
                let variationHtml = ``;
                $('.empty_vendor').remove();
                $.each(variationData.variations, function (i,v) {
                    let unidVar = 'var_' + inc++;
                    variationHtml += `
                       <tr draggable="false"
                           class="ui-sortable-handle variation_stock">
                           <td class="label">
                               <div class="d-flex align-items-center rtl:gap-2">
                                   <svg class="me-2" width="16" height="11" viewBox="0 0 16 11"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <rect width="16" height="1" fill="#898989">
                                       </rect>
                                       <rect y="5" width="16" height="1" fill="#898989">
                                       </rect>
                                       <rect y="10" width="16" height="1" fill="#898989">
                                       </rect>
                                   </svg>
                                   <input type="hidden" name="adjust[${index}][${ v.id }][product_id]" value="${ v.product_id }">
                                   <input type="hidden" name="adjust[${index}][${ v.id }][location_id]" value="${ v.location_id }">
                                   
                                   <label class="control-label">${ v.location.name }</label>
                               </div>
                           </td>
                           <td>
                               <label class="control-label" id="available_stock_${unidVar}">${ parseInt(v.available) }</label>
                           </td>
                           <td>
                               <input type="number" placeholder="0" class="form-control inputFieldDesign adjust_by" maxlength="8" id="adjust_by_${unidVar}" data-rowId="${unidVar}" name="adjust[${index}][${ v.id }][adjust_by]" value="0">
                           </td>
                           <td>
                               <input type="number" placeholder="0" class="form-control inputFieldDesign new_stock" maxlength="8" id="new_stock_${unidVar}" data-rowId="${unidVar}" name="adjust[${index}][${ v.id }][new]" value="${ parseInt(v.available) }">
                           </td>
                           <td>
                               <select class="form-control select2 sl_common_bx" name="adjust[${index}][${ v.id }][new]" required oninvalid="this.setCustomValidity('${ jsLang('This field is required.') }')">
                                   <option value="Correction">${ jsLang('Correction') }</option>
                                    <option value="Count">${ jsLang('Count') }</option>
                                    <option value="Received">${ jsLang('Received') }</option>
                                    <option value="Return_restock">${ jsLang('Return restock') }</option>
                                    <option value="Damaged">${ jsLang('Damaged') }</option>
                                    <option value="Theft_or_loss">${ jsLang('Theft or loss') }</option>
                                    <option value="Promotion_or_donation">${ jsLang('Promotion or donation') }</option>
                               </select>
                           </td>
                       </tr>
                `;
                });

                $.each(variationData.locations, function (ii,v) {
                    variationHtml += `
                     <tr draggable="false"
                        class="ui-sortable-handle variation_stock">
                        <td class="label">
                            <div class="d-flex align-items-center rtl:gap-2">
                                <svg class="me-2" width="16" height="11" viewBox="0 0 16 11"
                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="16" height="1" fill="#898989">
                                    </rect>
                                    <rect y="5" width="16" height="1" fill="#898989">
                                    </rect>
                                    <rect y="10" width="16" height="1" fill="#898989">
                                    </rect>
                                </svg>
                                <label class="control-label">${ v.name }</label>
                                <input type="hidden" name="location[${index}][${ v.id }][id]" value="${ v.id }">
                            </div>
                        </td>
                        <td>
                            <input type="number" placeholder="0" class="form-control inputFieldDesign" maxlength="8" name="location[${index}][${ v.id }][qty]" value="0">
                        </td>
                    </tr>
                    `;
                });
                
                $('#variation_stock_data_'+variationData.variation_id).append(variationHtml);
                
            });
            
            if (data.data['isInitialize'] == '1' && !isInitiaLize) {
                $('.variation_stock_data').each(function(i, v) {
                    let inititalVariationHtml = ``;
                    inititalVariationHtml = getRawVariationLocation(data.data['locations'], i);
                   $(this).append(inititalVariationHtml); 
                });
            } else if (data.data['isInitialize'] == '1' && isInitiaLize) {
                $('.variation_stock_data').each(function(i, v) {
                    let inititalVariationHtml = `<tr draggable="false" class="ui-sortable-handle empty_vendor">
                            <td colspan="3">${ jsLang('Please select & save vendor before save variations.') }</td>
                        </tr>`;
                    $(this).append(inititalVariationHtml);
                });
            }
            
                
            } else {
                $('#stock_msg').text(data.message);
                
                let varEmptyHtml = `<tr draggable="false" class="ui-sortable-handle">
                            <td colspan="3">${ jsLang('Location not found! Please create location for this vendor.') }</td>
                        </tr>`;
                $('.variation_stock_data').each(function(i, v) {
                    $(this).append(varEmptyHtml);
                });
            }
            
            $('#location_tab').html(html);
            
        },
        complete: function(data) {
            $('#temp_vendor_id').val(vendorId);
            resetSelect2Fields();
        }
    })
}

function getRawVariationLocation(locations, index)
{
    let inc = 123456;
    let unidVar = 'var_' + inc++;
    let variationHtml = ``;
    $.each(locations, function (i,v) {
    variationHtml += `
                      <tr draggable="false"
                        class="ui-sortable-handle variation_stock">
                        <td class="label">
                            <div class="d-flex align-items-center rtl:gap-2">
                                <svg class="me-2" width="16" height="11" viewBox="0 0 16 11"
                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="16" height="1" fill="#898989">
                                    </rect>
                                    <rect y="5" width="16" height="1" fill="#898989">
                                    </rect>
                                    <rect y="10" width="16" height="1" fill="#898989">
                                    </rect>
                                </svg>
                                <label class="control-label">${ v.name }</label>
                                <input type="hidden" name="location[${index}][${ v.id }][id]" value="${ v.id }">
                            </div>
                        </td>
                        <td>
                            <input type="number" placeholder="0" class="form-control inputFieldDesign" maxlength="8" name="location[${index}][${ v.id }][qty]" value="">
                        </td>
                    </tr>
                    `;
    });
    
    return variationHtml;
}

function stockResponse(response)
{

    let html = ``;
    html = getAdjustStockHtml(response.records.stocks)
    
    if (response.records.rowId != '') {
        $('#adjust_stock_div_'+response.records.rowId).replaceWith(html);
    } else {
        $('#location_tab').html(html);
    }
    
    
    $('#save_stock_div').addClass('display_none');
    $('#stock_msg').text(jsLang('Vendor stock will show here for each location.'));
    unblockEverything();
    resetSelect2Fields();
}

function getAdjustStockHtml(data)
{
    let html = ``;
    let inc = Math.floor((Math.random() * 100) + 1);
    let uid = '';
    $.each(data, function (i,v) {
        let unid = 'col_' + inc++;
        html += `
       <div class="location-dlt ui-sortable-handle" data-serial="${ i }" id="adjust_stock_div_${i}">
                <div class="d-flex justify-content-between align-items-center border-t h-40p mx-25n px-32p bg-F5 col-attr collapse-header"
                     data-bs-toggle="collapse" href="#${ unid = 'col_' + inc++ }">
                    <p class="label-title m-0 ml-16n-res font-weight-600 attribute-box-title">${ v.location.name }</p>
                    <div class="d-flex align-items-center">
                        <svg class="cursor-move mt-0" width="16" height="11" viewBox="0 0 16 11" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="1" fill="#898989" />
                            <rect y="5" width="16" height="1" fill="#898989" />
                            <rect y="10" width="16" height="1" fill="#898989" />
                        </svg>
                        <span
                            class="toggle-btn ml-10p mt-0 d-flex h-20 w-20 align-items-center justify-content-center inactive-sec collapsed"
                            data-bs-toggle="collapse" href="#${ unid }">
                            <svg width="8" height="6" viewBox="0 0 8 6" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.18767 5.90789L7.81732 1.34361C8.24162 0.810056 7.87956 -1.43628e-09 7.21678 -9.33983e-09L0.783223 -8.60592e-08C0.120445 -9.39628e-08 -0.241618 0.810055 0.182683 1.34361L3.81233 5.90789C3.91 6.0307 4.09 6.0307 4.18767 5.90789Z"
                                    fill="#2C2C2C" />
                            </svg>
                        </span>
                        
                    </div>
                </div>
                <div class="collapse" id="${ unid }">
                    <div class="row m-0 px-7 pb-30p">
                                              
                        <input type="hidden" name="product_id" value="${ v.product_id }">
                        <input type="hidden" name="location_id" value="${ v.location_id }">
                        <input type="hidden" name="row_id" value="${ i }">

                        <div class="form-group row">
                            <label class="col-sm-6 control-label" for="inputEmail3">${ jsLang('Available') }</label>

                            <label class="col-sm-6 control-label" for="inputEmail3" id="available_stock_${unid}">${ parseInt(v.available) }</label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-6 control-label require" for="inputEmail3">${ jsLang('Adjust By') }</label>

                            <div class="col-sm-6">
                                <input type="number" placeholder="${ jsLang('Adjust By') }" value="0" class="form-control adjust_by inputFieldDesign adjust_by" name="adjust_by" id="adjust_by_${unid}" data-rowId="${unid}" required oninvalid="this.setCustomValidity('${ jsLang('This field is required.') }')">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-6 control-label require" for="inputEmail3">${ jsLang('New') }</label>

                            <div class="col-sm-6">
                                <input type="number" placeholder="${ jsLang('New') }" value="${ parseInt(v.available) }" class="form-control new inputFieldDesign new_stock" name="new" id="new_stock_${unid}" data-rowId="${unid}" required oninvalid="this.setCustomValidity('${ jsLang('This field is required.') }')">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-6 control-label require pr-0 "
                                   for="inputEmail3">${ jsLang('Reason') }</label>
                            <div class="col-sm-6">
                                <select class="form-control select2 sl_common_bx" name="reason" required oninvalid="this.setCustomValidity('${ jsLang('This field is required.') }')">
                                    <option value="Correction">${ jsLang('Correction') }</option>
                                    <option value="Count">${ jsLang('Count') }</option>
                                    <option value="Received">${ jsLang('Received') }</option>
                                    <option value="Return_restock">${ jsLang('Return restock') }</option>
                                    <option value="Damaged">${ jsLang('Damaged') }</option>
                                    <option value="Theft_or_loss">${ jsLang('Theft or loss') }</option>
                                    <option value="Promotion_or_donation">${ jsLang('Promotion or donation') }</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="mt-25p mx-7p px-6 border-t mx-25n px-32p">
                            <a href="javascript:void(0)" class="w-175p btn-confirms mt-24p update_adjust" data-rowId="${ i }">${ jsLang('Update') }</a>
                        </div>
                      
                    </div>
                </div>
            </div>
     `;
    });
    
    return html;
}

const unblockEverything = () => {
    $(".blockUI").each(function () {
        $(this).parent().unblock();
    });
};

const resetSelect2Fields = () => {
    $("select.select2").select2({
        allowClear: false,
        placeholder: jsLang("Select an option"),
    });

    $("select.select2clearable").select2({
        allowClear: true,
        placeholder: jsLang("Select an option"),
    });
};

$(document).on('blur change', '.adjust_by', function () {
    
    if ($(this).val() == '') {
        $(this).val(0);
        $(this).trigger('change');
    }
    
    $(this).val(parseInt($(this).val()));

    let rowId = $(this).attr('data-rowId');
    let availableStock = parseInt($('#available_stock_'+rowId).text());

    $('#new_stock_'+rowId).val(parseInt(availableStock) + parseInt($(this).val()));
    
})

$(document).on('blur change', '.new_stock', function () {

    if ($(this).val() == '') {
        $(this).val(0);
        $(this).trigger('change');
    }

    $(this).val(parseInt($(this).val()));

    let rowId = $(this).attr('data-rowId');
    let availableStock = parseInt($('#available_stock_'+rowId).text());
    
   $('#adjust_by_'+rowId).val(parseInt($(this).val()) - parseInt(availableStock));
})

const triggerNotification = (msg) => {
    $(".notification-msg-bar").find(".notification-msg").html(msg);
    $(".notification-msg-bar").removeClass("smoothly-hide");
    setTimeout(() => {
        $(".notification-msg-bar").addClass("smoothly-hide"),
            $(".notification-msg-bar").find(".notification-msg").html("");
    }, 2500);
};



