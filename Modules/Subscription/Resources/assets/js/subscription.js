'use strict';

$(function () {
    var pagination = ['v-pills-general-tab', 'v-pills-optional-tab', 'v-pills-optionals-tab'];

    if (typeof dynamic_page !== 'undefined') {
        pagination = ['v-pills-general-tab'];
        for (const value of dynamic_page) {
            pagination.push(`v-pills-${value}-tab`)
        }
    }

    function tabTitle(id) {
        var title = $('#' + id).attr('data-id');
        $('#theme-title').html(title);
    }


    $(document).on("click", '.tab-name', function () {
        var id = $(this).attr('data-id');
        $('#theme-title').html(id);
    });

    $(document).on('click', 'button.switch-tab', function (e) {
        $('#' + $(this).attr('data-id')).tab('show');
        var titleName = $(this).attr('data-id');

        tabTitle(titleName);

        $('.tab-pane[aria-labelledby="home-tab"').addClass('show active')
        $('#' + $(this).attr('id')).addClass('active').attr('aria-selected', true)
    })

    // Hide export option
    var hideExport = setInterval(() => {
        if ($("#btnGroupDrop1").length) {
            $("#btnGroupDrop1").css('display','none')
            $(".btn-group").css({'display':'inline-block'})
            $("#dataTableBuilder_length").css({'margin-top':'-20px'})
            clearInterval(hideExport);
        }
    }, 100);

    $(document).on("keyup", ".int-number", function () {
        let number = $(this).val();
        $(this).val(number.replace(/[^0-9-]/g, ""));
    });

    $(".package-submit-button, .package-feature-submit-button, .credit-submit-button").on("click", function () {
        setTimeout(() => {
            for (const data of pagination) {
                if ($('#' + data.replace('-tab', '')).find(".error").length) {
                    var target = $('#' + data.replace('-tab', '')).attr("aria-labelledby");
                    $('#' + target).tab('show');
                    tabTitle(target);
                    break;
                }
            }
        }, 100);
    });

    $('.add-feature-nav').on('click', function () {
        var count = $(this).attr('data-count');
        var nav = $('#add-feature-nav').find('li a')

        nav.attr('id', `v-pills-${count}-tab`)
            .attr('href', `#v-pills-${count}`)
            .attr('aria-controls', `v-pills-${count}`)
            .attr('data-id', jsLang('Custom') + count)

        nav.text(jsLang('Custom') + count)

        $(this).attr('data-count', +count + 1);
        $(this).before($('#add-feature-nav').html())

        var data = $('#add-feature-data');
        data.find('.tab-pane')
            .attr('id', `v-pills-${count}`)
            .attr('aria-labelledby', `v-pills-${count}-tab`)

        data.find('.type').attr('name', `meta[custom${count}][type]`);
        data.find('.title').attr('name', `meta[custom${count}][title]`);
        data.find('.description').attr('name', `meta[custom${count}][description]`);
        data.find('.is_visible').attr('name', `meta[custom${count}][is_visible]`).addClass('select2-dynamic');
        data.find('.status').attr('name', `meta[custom${count}][status]`).addClass('select2-dynamic');


        $('#topNav-v-pills-tabContent').append(data.html());
        $('#add-feature-data').find('.is_visible, .status').removeClass('select2-dynamic');

        $(".select2-dynamic").select2({
            minimumResultsForSearch: Infinity
        });
    })

    $(document).on('click', '.custom-feature-nav .close', function () {
        $('#v-pills-general-tab').tab('show');
        tabTitle('v-pills-general-tab');

        var id = $(this).siblings('a').attr('aria-controls')
        $(this).closest('.custom-feature-nav').remove();
        $('#' + id).remove()
    })

    // Subscription add section
    if ($('#subscription-add-container').length) {
        $('input[name="activation_date"]').daterangepicker(dateSingleConfig());
        $('input[name="billing_date"]').daterangepicker(dateSingleConfig());
        $('input[name="next_billing_date"]').daterangepicker(dateSingleConfig());
    }

    // Subscription edit section (Admin panel)
    if ($('#subscription-edit-container').length) {
        $('input[name="activation_date"]').daterangepicker(dateSingleConfig($('input[name="activation_date"]').val()));
        $('input[name="billing_date"]').daterangepicker(dateSingleConfig($('input[name="billing_date"]').val()));
        $('input[name="next_billing_date"]').daterangepicker(dateSingleConfig($('next_input[name="billing_date"]').val()));
    }

    function validateDateOrder() {
        const activationInput = $('input[name="activation_date"]');
        const nextBillingInput = $('input[name="next_billing_date"]');

        const activationDate = moment(activationInput.val(), dateFormatForMoment);
        const nextBillingDate = moment(nextBillingInput.val(), dateFormatForMoment);

        if (activationDate.isAfter(nextBillingDate)) {
            const correctedDate = nextBillingDate.clone().subtract(billing_cycles[$('#billing_cycle').val()], 'days');
            activationInput.val(correctedDate.format(dateFormatForMoment));
            activationInput.data('daterangepicker').setStartDate(correctedDate);
            activationInput.data('daterangepicker').setEndDate(correctedDate);
        }
    }

    // Attach event listeners
    $('input[name="activation_date"]').on('change', function () {
        validateDateOrder();
    });

    $('input[name="next_billing_date"]').on('change', function () {
        validateDateOrder();
    });

    $('input[name="billing_date"], input[name="activation_date"], input[name="next_billing_date"]').on('change', function () {
        var activation_date = $('input[name="activation_date"]').val();
        var billing_date = $('input[name="billing_date"]').val();
        var next_billing_date = $('input[name="next_billing_date"]').val();
        
        if (moment(activation_date).isAfter(billing_date) || !moment(next_billing_date).isAfter(billing_date)) {
            $('input[name="billing_date"]').val(activation_date);
            $('input[name="billing_date"]').data('daterangepicker').setStartDate(activation_date);
            $('input[name="billing_date"]').data('daterangepicker').setEndDate(activation_date);
        }
    });

    $('#billing_cycle').on('change', function () {
        var val = $(this).val();

        if (val == 'days') {
            $('#duration_days').removeClass('d-none');
        } else {
            $('#duration_days').addClass('d-none');
        }
    })

    //Send Invoice
    $(document).on('click', '#email_invoice', function(e) {
        e.preventDefault();
        parent = this;

        $(this).attr('disabled', true).find('.feather').addClass('icon-loader');

        $.ajax({
            url: $(parent).attr('url'),
            type: "get",

            success: function(data) {
                $('.top-notification').removeClass('d-none').find('.alert').addClass('alert-success').removeClass('alert-danger').find('.alertText').text(data.message);
            },
            complete: function() {
                $(parent).removeAttr('disabled').find('.feather').removeClass('icon-loader');
            }
        });
    })

    function getPackageData(package_id) {
        var deferred = $.Deferred();
        $.ajax({
            url: SITE_URL + "/package/get-info/" + package_id,
            type: "get",

            success: function (data) {
                deferred.resolve(data);
            }
        });

        return deferred.promise();
    }

    function setRenewable(data) {
        if (data) {
            $('#renewable').val(data.renewable);
        }
    }

    function setTransaction(data) {
        if (data) {
            var cycle = $('#billing_cycle').val()
            var price = data.discount_price[cycle] > 0 ? data.discount_price[cycle] : data.sale_price[cycle]
            $('#billing_price, #amount_billed').val(price)

            if ($('#payment_status').val() == 'Paid') {
                $('#amount_received').val(price)
                $('#amount_due').val(0)
            } else {
                $('#amount_due').val(price)
                $('#amount_received').val(0)
            }

            if (cycle == 'days') {
                $('#duration_days').removeClass('d-none')
                $('#duration').val(data.duration).attr('readonly', true)
            } else {
                $('#duration_days').addClass('d-none')
                $('#duration').val('').attr('readonly', true)
            }
        }
    }

    const billing_cycles = {
        'lifetime': 0,
        'yearly': 365,
        'monthly': 30,
        'weekly': 7,
    }

    function setDate(data) {
        var day = 1;
        var cycle = $('#billing_cycle').val()
        if (cycle == 'days') {
            day = data.duration;
        } else {
            day = billing_cycles[cycle]
        }

        if ($('#subscription-add-container').length || $('#subscription-edit-container').length) {

            $('input[name="next_billing_date"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: moment().add(day, 'day'),
                minDate: moment().add(1, 'day'),
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        }
    }

    function setBillingCycle(data, billing_cycle = null) {
        $('#billing_cycle').html('');
        for (const key in data.billing_cycle) {
            if (data.billing_cycle[key] == 1) {
                $('#billing_cycle').append(`
                    <option ${billing_cycle == key ? 'selected' : ''}  value="${key}">${key.charAt(0).toUpperCase() + key.slice(1)}</option>
                `)
            }
        }

        $('.select2-hide-search').select2({
            minimumResultsForSearch: Infinity
        });
    }

    function setMetaData(data) {
        for (const key in data) {
            if (data[key].key == 'value') {
                $('input[name="meta[' + data[key].feature + '][value]"]').val(data[key].value);

                $('select[name="meta[' + data[key].feature + '][value]"]').val(data[key].value).trigger('change');
                
                const $multiSelect = $('select[name="meta[' + data[key].feature + '][value][]"]');
                
                if ($multiSelect.length) {
                    $multiSelect.find('option').prop('selected', false);
                    var arr = JSON.parse(data[key].value.replace(/'/g, '"'));

                    for (var i = 0; i < arr.length; i++) {
                        $multiSelect.find('option[value="' + arr[i] + '"]').prop('selected', true);
                    }
                }
            }
        }
    }

    //Set renewable data from package
    $('.select2#package_id').on('select2:select', function(e) {
        var package_id = e.params.data.id;
        var promise = getPackageData(package_id);

        promise.done(function(data) {            
            setMetaData(data.metadata);
            
            setRenewable(data);
            setBillingCycle(data);
            setTransaction(data);
            setDate(data);
        });
    });

    if ($('#subscription-edit-container').length) {
        var promise = getPackageData($('.select2#package_id').val());

        promise.done(function(data) {
            var billing_cycle = $('#billing_cycle').val();
            setBillingCycle(data, billing_cycle);
        });
    }

    if ($('#subscription-add-container').length) {
        var promise = getPackageData($('.select2#package_id').val());

        promise.done(function(data) {
            setRenewable(data);
            setBillingCycle(data);
            setTransaction(data);
            setDate(data);
        });
    }

    $('.select2-hide-search#billing_cycle').on('select2:select', function(e) {

        var val = $(this).val();

        if (val == 'days') {
            $('#duration_days').removeClass('d-none');
        } else {
            $('#duration_days').addClass('d-none');
        }

        var promise = getPackageData($('.select2#package_id').val());

        promise.done(function(data) {
            setRenewable(data);
            setTransaction(data);
            setDate(data);
        });
    });

    $('.select2-hide-search#payment_status').on('select2:select', function(e) {
        var payment_status = e.params.data.text;
        var price = $('#billing_price').val();

        if (payment_status == 'Paid') {
            $('#amount_received').val(price)
            $('#amount_due').val(0);
        } else {
            $('#amount_received').val(0)
            $('#amount_due').val(price);
        }
    });

    function billingReadOnly(checkbox, readonly = true) {
        var textField = $(checkbox).closest('.billing-parent').find('input[type="text"]');

        textField.attr('readonly', readonly);

        if (readonly) {
            textField.val(null);
        }
    }

    $('.billing-checkbox').on('change', function() {
        if ($(this).is(':checked')) {
            billingReadOnly(this, false)
        } else {
            billingReadOnly(this, true)
        }
    });

    //Plan Pricing
    $('input[name="check_billing"]').on('change', function() {
        var value = $(this).val();
        $('.plan-parent').addClass('d-none');

        if ($(`.plan-${value}`).length == 0) {
            $('.plan-root').append(`
                <div class="plan-parent plan-${value}">
                    <p class="text-color-14 dark:text-white mx-auto text-[22px] leading-6 font-semibold px-5 break-words text-center">${jsLang('No plan available under this category')}</p>
                </div>
            `)
        } else {
            $(`.plan-${value}`).removeClass('d-none');
        }
    })

    $('#user_list').on('change', function() {
        $('#user_email').val($(this).val());
    })

    $(document).on('click', '.link-modal', function() {
        $('#generate_link_btn').attr('data-id', $(this).attr('id'));
    })

    $('#generate_link_btn').on('click', function() {
        const planId = $(this).attr('data-id');
        const email = $('#user_email').val();

        $.ajax({
            url: generateLinkUrl,
            type: "post",
            data: {
                '_token': token,
                'plan_id': planId,
                'email': email
            },
            success: function(data) {
                $('#all_links').removeClass('d-none');
                $('#all_links').find('tbody').prepend(`
                    <tr>
                        <td>${data.data.link.substr(data.data.link.length - 40)}</td>
                        <td><button title="${data.data.email}" class="copy-link-btn" data-link="${data.data.link}">${jsLang('Copy Link')}</button></td>
                    </tr>
                `);
            }
        });
    })

    $('#get_generate_link_btn').on('click', function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url: ADMIN_SITE_URL + '/package/generate-link/' + id,
            type: "get",
            success: function(data) {
                $('#all_links').removeClass('d-none');
                $('#all_links').find('tbody').empty()
                for (const key in data.data) {
                    $('#all_links').find('tbody').append(`
                        <tr>
                            <td>${data.data[key].link.substr(data.data[key].link.length - 40)}</td>
                            <td><button title="${data.data[key].email}" class="copy-link-btn" data-link="${data.data[key].link}">${jsLang('Copy Link')}</button></td>
                        </tr>
                    `);
                }

                $('#get_generate_link_btn').remove();
            }
        });
    });

    $(document).on('click', '.copy-link-btn', function() {
        var linkToCopy = $(this).attr('data-link');
        var icon = $(this).html();

        navigator.clipboard.writeText(linkToCopy);

        $(this).html('<i class="feather icon-check"></i>');

        setTimeout(() => {
            $(this).html(icon);
        }, 2000);
    })

    $(document).on("keyup", "#subscription_remaining_days, #subscription_expire_days", function () {
        let text = $(this).val();
        if (text[0] == ',') {
            text = text.slice(text[1], text);
        }
        text = text.replace(/[^0-9-,]/g, "");
        const numbers = text.split(",");
        var numberArray = numbers.map(function(number) {
            if (Number(number) > 365) {
                return 365;
            }
            return number;
        })

        $(this).val(numberArray.toString());
    });

    $(document).on('click', '.mail-modal', function() {
        var schedules = JSON.parse($(this).attr('data-schedule-dates'));
        var schedulesDbDates = JSON.parse($(this).attr('data-schedule-db-dates'));
        var type = $(this).attr('data-mail-type');
        var last_send = $(this).attr('data-last-sent-mail');

        $('#last_sent_mail').text(last_send);
        $('#mail_type').text(type);
        $('#mail_type_input').val(type);
        $('#subscription_id').val($(this).attr('id'));

        var scheduleHtml = '';
        var isScheduleToday = false;

        for (const iterator of schedules) {
            scheduleHtml += `<p>${iterator}</p>`
        }

        for (const iterator of schedulesDbDates) {
            if (!isScheduleToday && isDateToday(iterator)) {
                isScheduleToday = true;
            }
        }

        $('#schedule_dates').html(scheduleHtml);

        var btn = 'disabled';
        $('#manual_mail_submit').removeClass('conditionally-enabled');
        $('#immediate_mail').attr('disabled', false);
        if (isScheduleToday) {
            btn = false;
            $('#manual_mail_submit').addClass('conditionally-enabled');
            $('#immediate_mail').attr('disabled', 'disabled');
        }

        $('#manual_mail_submit').attr('disabled', btn);
    })

    function isDateToday(dateString) {
        // Convert the input date string to a Date object
        const inputDate = new Date(dateString);

        // Get today's date
        const today = new Date();

        // Compare the year, month, and day of the two dates
        return (
          inputDate.getFullYear() === today.getFullYear() &&
          inputDate.getMonth() === today.getMonth() &&
          inputDate.getDate() === today.getDate()
        );
    }

    $(document).on('change', '#immediate_mail', function() {
        if (this.checked) {
            $('#manual_mail_submit').attr('disabled', false);
        } else if (!$('#manual_mail_submit').hasClass('conditionally-enabled')) {
            $('#manual_mail_submit').attr('disabled', 'disabled');
        }
    });

    let packageLimitTimeout;

    $(document).on('input', '.package-limit', function () {
        const $input = $(this);

        clearTimeout(packageLimitTimeout); // Clear previous timeout if user types again

        packageLimitTimeout = setTimeout(() => {
            let value = $input.val().trim();

            if (value === '-') {
                $input.val(-1);
                return;
            }

            let numericValue = Number(value);
            if (isNaN(numericValue) || numericValue < -1) {
                $input.val(-1);
            }
        }, 1000); // 1000 milliseconds = 1 second
    });
})
