"use strict";

    let loader = `<option value="">${jsLang('Loading')}...</option>`;
    let selectCity = `<option value="">${jsLang('Select City')}</option>`;
    let selectState = `<option value="">${jsLang('Select State')}</option>`;
    let errorMsg = jsLang(':x is not available.');
    $('.addressSelect').select2();

    $.ajax({
        url: url + "/geo-locale/countries",
        type: "GET",
        dataType: 'json',
        beforeSend: function() {
            $('#country').html(loader);
            $('#country').attr('disabled','true');
        },
        success: function(result) {
            $('#country').html('<option value="">' + jsLang('Select Country') + '</option>');
            $.each(result, function(key, value) {
                $("#country").append(`'<option  ${value.code==oldCountry?'Selected': ''} data-country="${value.code}" value="${ value.code}">${value.name}</option>'`);
            });
            $("#country").removeAttr("disabled");
        }
    });


    if (oldState != "null") {
        getState(oldCountry);
    }
    if (oldCity != "null") {
        getCity(oldState,oldCountry);
    }


    $('#country').on('change', function() {
        oldCity = "null";
        getState($('#country').find(':selected').attr('data-country'));
    });

    function getState( country_code ) {

        if (country_code) {
            $("#state").html('');
            if (oldCity == "null") {
                $('#city').html(selectCity);
            }
            $.ajax({
                url: url + "/geo-locale/countries/" + country_code + "/states",
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    $('#state').attr('disabled','true');
                    $('#state').html(loader);
                },
                success: function(result) {
                    $('#state').html(selectState);

                    $.each(result.data, function(key, value) {
                        $("#state").append(`'<option ${value.id == oldState ? 'Selected': ''} data-state="${value.code}" value="${value.id}">${value.name}</option>'`);
                    });

                    $("#state").removeAttr("disabled");

                    if (result.length <= 0 && result.data.length <= 0) {
                        errorMsg = errorMsg.replace(":x", 'State');
                        $('#state').html(`<option value="">${errorMsg}</option>`);
                    }
                }
            });
        } else {

            $('#state').html(selectState);
            $('#city').html(selectCity);
        }
    }

    $('#state').on('change', function() {
        getCity($('#state').find(':selected').attr('data-state'), $('#country').find(':selected').attr('data-country'));
    });

    function getCity( siso, ciso) {

        if (siso && ciso) {
            $("#city").html('');
            $.ajax({
                url: url + "/geo-locale/countries/" + ciso + "/states/" + siso +
                    "/cities",
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    $('#city').html(loader);
                    $('#city').attr('disabled','true');
                },
                success: function(res) {
                    $('#city').html(selectCity);
                    $.each(res.data, function(key, value) {
                        $("#city").append(`<option ${value.name == oldCity ? 'Selected': ''} value="${value.name}">${value.name}</option>`);
                    });
                    $("#city").removeAttr("disabled");
                    if (res.length <= 0 && res.data.length <= 0) {
                        errorMsg = errorMsg.replace(":x", 'City');
                        $('#city').html(`<option value="">${errorMsg}</option>`);
                    }
                }
            });

        } else {
            $('#city').html(selectCity);
        }
    }
if ($('.main-body .page-wrapper').find('#location-add-container').length || $('.main-body .page-wrapper').find('#purchase-add-container').length) {
    $(document).on('keyup', '#name', function () {
        var str = this.value.replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g, "");
        $('#slug').val(str.trim().toLowerCase().replace(/\s/g, "-"));
        $('#slug').parent().removeClass('has-validation-error');
        $('#slug').parent().find('label').remove();
    });

    $(document).on('keyup', '#slug', function () {
        var str = this.value.replace(/[&\/\\#@,+()$~%.'":*?<>{}]/g, "");
        $('#slug').val(str.trim().toLowerCase().replace(/\s/g, "-"));
    });
}
