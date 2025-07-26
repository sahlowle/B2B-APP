"use strict";

//## Address
if ($('#customer_address_create, #customer_address_edit').length) {
    let radioSwitch = $('.radio-test').is(':checked');
    $('.radio-test').on('click', function() {
        $('.radio-error-msg').hide();
        radioSwitch= true;
    });

    $('.save-add-func').on('click', function() {
        if(!radioSwitch){
            $('.radio-error-msg').show();
        }
        else{
            $('.radio-error-msg').hide();
        }
    })

    function formValidation() {
        if ($('.addressForm').find('.error').length > 0) {
            return false;
        } else {
            $('#btnSubmit').attr('disabled','true');
            return true;
        }
    }


    $(document).ready(function() {
        $('.addressSelect').select2();

        // select2 autofocus
        $(document).on('select2:open', (e) => {
            const selectId = e.target.id

            $(".select2-search__field[aria-controls='select2-" + selectId + "-results']").each(function(
                key,
                value,
            ) {
                value.focus();
            })
        })

        let loader = `<option value="">${jsLang('Loading')}...</option>`;
        let selectCity = `<option value="">${jsLang('Select City')}</option>`;
        let selectState = `<option value="">${jsLang('Select State')}</option>`;
        let errorMsg = jsLang(':x is not available.');
        
        getCity($('#state').find(':selected').attr('data-state'), oldCountry);

        // initially country loading

        if ($('.address-form , .checkout-address-form').find('#addressForm').length) {
            $.ajax({
                url: SITE_URL + "/geo-locale/countries",
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    $('#country').html(loader);
                    $('#country').attr('disabled','true');
                },
                success: function(result) {
                    $('#country').html('<option value="">' + jsLang('Select Country') + '</option>');
                    $.each(result, function(key, value) {
                    $("#country").append(`'<option  ${value.code==oldCountry?'selected': ''} data-country="${value.code}" value="${ value
                            .code}">${value.name}</option>'`);
                    });
                    $("#country").removeAttr("disabled");
                }
            });
        }

        if (oldState != "null") {
            getState(oldCountry);
        }

        $('#country').on('change', function() {
            let str = $(this).find(':selected').html();
            oldCity = "null";

            if (str.length > 0) {
                let selector = this.closest('.validSelect');
                selector.querySelector('.addressSelect').setCustomValidity("");
                if (selector.querySelector('.error')) {
                    selector.querySelector('.error').remove();
                }
            }
            getState($('#country').find(':selected').attr('data-country'));
            getCity($('#state').find(':selected').attr('data-state'), $('#country').find(':selected').attr('data-country'));
        });

        function getState( country_code ) {
            if (country_code) {
                $("#state").html('');
                if (oldCity == "null") {
                    $('#city').html(selectCity);
                }
                $.ajax({
                    url: SITE_URL + "/geo-locale/countries/" + country_code + "/states",
                    type: "GET",
                    dataType: 'json',
                    beforeSend: function() {
                    $('#state').attr('disabled','true');
                    $('#state').html(loader);
                    },
                    success: function(result) {
                    $('#state').html(selectState);
                    $.each(result.data, function(key, value) {
                            $("#state").append(`'<option ${value.code==oldState?'Selected': ''} data-state="${value.code}" value="${value.code}">${value.name}</option>'`);
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
            let str = $(this).find(':selected').html();

            if (str.length > 0) {
                let selector = this.closest('.validSelect');
                selector.querySelector('.addressSelect').setCustomValidity("");
                if (selector.querySelector('.error')) {
                    selector.querySelector('.error').remove();
                }
            }
            getCity($('#state').find(':selected').attr('data-state'), $('#country').find(':selected').attr('data-country'));

        });

        function getCity(siso, ciso) {
            if (oldCity == "null") {
                $('#city').html(selectCity);
            }
            
            if (ciso === null || ciso === 'null') {
                return;
            }
            
            var ajaxUrl = SITE_URL + "/admin/countries/" + ciso + "/cities";
            
            if (siso !== undefined && siso !== '' && siso != null) {
                ajaxUrl = SITE_URL + "/geo-locale/countries/" + ciso + "/states/" + siso + "/cities";
            }
            
            $("#city").select2({
                ajax: {
                    url: ajaxUrl,
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term, // search term
                            page: params.page,
                        };
                    },
                    processResults: function (data, params) {
                        var processData = [];
                        
                        $.each(data.data, function(key, value) {
                            processData.push({id: value.name, text: value.name});
                        });
                        
                        return {
                            results: processData
                        };
                    },
                    cache: true,
                },
                placeholder: jsLang("Start typing to search"),
                minimumInputLength: 1,
            });
        }
        
        $('#city').on('change', function() {
            let str = $(this).find(':selected').html();

            if (str.length > 0) {
                let selector = this.closest('.validSelect');
                selector.querySelector('.addressSelect').setCustomValidity("");
                if (selector.querySelector('.error')) {
                selector.querySelector('.error').remove();
                }
            }
        });
    });
}

//## Common
if ($('#customer_addresses, #customer_refund_create, #customer_refunds, #customer_download, #user_notification_container, #user_profile, #customer_reviews, #customer_settings').length) {
    $(".open-delete-modal").on('click', function() {
        $(".delete-modal").css("display", "flex");
        $('.delete-modal form').attr('action', $(this).data('url'));
        $('.delete-modal input[name=_method]').val($(this).data('method'));
        $(".delete-modal-container").show();
    });
    
    $('.close-btn').on('click', function() {
        $(".delete-modal").hide();
    });
    
    $('.genderSelect').select2();
    
    $(".open-pass-modal").on('click', function() {
        $(".pass-modal").css("display", "flex");
    });
    
    $('.pass-close-btn').on('click', function() {
        $(".pass-modal").hide();
    });
    
    $('.customer-filter').on('change', function() {
        var selectedValue = $(this).val();
        var url = new URL(window.location.href);
        var params = new URLSearchParams(url.search);
    
        // Set or update the query parameter
        params.set($(this).data('type'), selectedValue);
    
        // Update the URL and refresh the page
        url.search = params.toString();
        window.location.href = url.toString();
    });   
}

//## Refund
if ($('#customer_refund_create').length) {
    function quantitySelect() {
        var qty = $("select[name='order_items']").find(':selected').data('quantity');
        var orderDetailId = $("select[name='order_items']").find(':selected').data('order_detail_id');
        $('input[name="order_detail_id"]').val(orderDetailId)
        $("select[name='quantity_sent']").html(`<option value="">${jsLang('Select one')}</option>`);
        for (let index = 1; index <= qty; index++) {
            $("select[name='quantity_sent']").append(`
                <option value="${index}">${index}</option>
            `)
        }
    }
    
    var itemFind = false;
    function findProducts(reference) {
        $.ajax({
            url: SITE_URL + "/myaccount/refund-products/" + reference,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('#order_items').html(`<option value="">${jsLang('Select one')}</option>`);
                for (const key in data[reference]) {
                    var variations = "";
                    var payloads = data[reference][key].payloads;
                    
                    if (payloads) {
                        payloads = JSON.parse(payloads);
                        payloads = Object.entries(payloads).map(([key, value]) => `${key}: ${value}`).join(', ');
                        variations = `(${payloads})`;
                    }
                    
                    $('#order_items').append(`
                        <option ${product_id == data[reference][key].product_id ? 'selected' : ''} data-order_detail_id="${data[reference][key].id}" data-quantity="${data[reference][key].quantity}" value="${data[reference][key].product_id}">
                            ${data[reference][key].product_name} ${variations}
                        </option>
                    `)
                }
                itemFind = true;
            }
        })
    }
    
    if (product_id > 0) {
        findProducts($("select[name='order_reference']").val());
        var refund_count = 1;
        var intervals = setInterval(() => {
            refund_count++;
            if (itemFind == true) {
                quantitySelect();
                clearInterval(intervals);
            }
            if (refund_count == 300) {
                clearInterval(intervals);
            }
        }, 100);
    }
    
    $("select[name='order_reference']").on('change',function() {
        var tmp = this;
        clearTimeout(debounce );
        var debounce = setTimeout(function() {
            var reference = $(tmp).val();
            if (reference) {
                findProducts(reference);
            } else {
                $('#order_items').html(`<option value="">${jsLang('Select one')}</option>`)
                $("select[name='quantity_sent']").html(`<option value="">${jsLang('Select one')}</option>`);
            }
    
        }, 100);
    })
    
    $("select[name='order_items']").on('change', function() {
        quantitySelect();
    });
    
    // Message box scroll bar move to bottom
    var messageBox = $('.message-box');
    messageBox.scrollTop(messageBox.prop("scrollHeight"));
    
    $('.refund-select').select2();
    
    // file upload
    const fileContainer = document.getElementById("file-container");
    const deleteModal = document.querySelector(".index-modal");
    let fileToDelete = null;
    
    const refundDt = new DataTransfer();
    var refundObj = {};
    
    document.querySelectorAll(".drop-zone-input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");
    const errorMessage = document.getElementById("error-message");
    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });
    
    let isDropped = false;
    
    inputElement.addEventListener("change", (e) => {
        const files = inputElement.files;
        const validFiles = Array.from(files).filter((file) => {
        const fileExtension = getFileExtension(file.name);
            return isAllowedExtension(fileExtension);
        });
    
        if (validFiles.length === 0) {
            errorMessage.classList.remove("hidden");
            return;
        }
        
        errorMessage.classList.add("hidden");
        
        for (let i = 0; i < validFiles.length; i++) {
            var f = files[i];
            refundDt.items.add(f);
            var rand = (Math.random() + 1).toString(36).substring(7);
            refundObj[rand] = f;
        
            const fileDiv = document.createElement("div");
            fileDiv.classList.add("file-container");
            const fileElement = createFileElement(validFiles[i]);
            const closeButton = document.createElement("button");
            closeButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M8 3C8 2.44772 8.44772 2 9 2H15C15.5523 2 16 2.44772 16 3C16 3.55228 15.5523 4 15 4H9C8.44772 4 8 3.55228 8 3ZM4.99224 5H3C2.44772 5 2 5.44772 2 6C2 6.55228 2.44772 7 3 7H4.06445L4.70614 16.6254C4.75649 17.3809 4.79816 18.006 4.87287 18.5149C4.95066 19.0447 5.07405 19.5288 5.33109 19.98C5.73123 20.6824 6.33479 21.247 7.06223 21.5996C7.52952 21.826 8.0208 21.917 8.55459 21.9593C9.06728 22 9.69383 22 10.4509 22H13.5491C14.3062 22 14.9327 22 15.4454 21.9593C15.9792 21.917 16.4705 21.826 16.9378 21.5996C17.6652 21.247 18.2688 20.6824 18.6689 19.98C18.926 19.5288 19.0493 19.0447 19.1271 18.5149C19.2018 18.006 19.2435 17.3808 19.2939 16.6253L19.9356 7H21C21.5523 7 22 6.55228 22 6C22 5.44772 21.5523 5 21 5H19.0078C19.0019 4.99995 18.9961 4.99995 18.9903 5H5.00974C5.00392 4.99995 4.99809 4.99995 4.99224 5ZM17.9311 7H6.06889L6.69907 16.4528C6.75274 17.2578 6.78984 17.8034 6.85166 18.2243C6.9117 18.6333 6.98505 18.8429 7.06888 18.99C7.26895 19.3412 7.57072 19.6235 7.93444 19.7998C8.08684 19.8736 8.30086 19.9329 8.71286 19.9656C9.13703 19.9993 9.68385 20 10.4907 20H13.5093C14.3161 20 14.863 19.9993 15.2871 19.9656C15.6991 19.9329 15.9132 19.8736 16.0656 19.7998C16.4293 19.6235 16.7311 19.3412 16.9311 18.99C17.015 18.8429 17.0883 18.6333 17.1483 18.2243C17.2102 17.8034 17.2473 17.2578 17.3009 16.4528L17.9311 7ZM10 9.5C10.5523 9.5 11 9.94772 11 10.5V15.5C11 16.0523 10.5523 16.5 10 16.5C9.44772 16.5 9 16.0523 9 15.5V10.5C9 9.94772 9.44772 9.5 10 9.5ZM14 9.5C14.5523 9.5 15 9.94772 15 10.5V15.5C15 16.0523 14.5523 16.5 14 16.5C13.4477 16.5 13 16.0523 13 15.5V10.5C13 9.94772 13.4477 9.5 14 9.5Z" fill="white"/></svg>`;
            closeButton.classList.add("close-button");
            closeButton.addEventListener("click", () => {
                fileToDelete = fileDiv;
            });
            fileDiv.appendChild(fileElement);
            fileDiv.appendChild(closeButton);
            fileContainer.appendChild(fileDiv);
        }
    });
    function isAllowedExtension(extension) {
        const allowedExtensions = ["jpg", "jpeg", "jfif" , "pjpeg" , "pjp" , "png", "gif","svg","gif"];
        return allowedExtensions.includes(extension);
    }
    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone-over");
    });
    
    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
        dropZoneElement.classList.remove("drop-zone-over");
        });
    });
    
    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();
        isDropped = true;
    
        if (e.dataTransfer.files.length) {
        const files = Array.from(e.dataTransfer.files);
        const validFiles = files.filter((file) => {
            const fileExtension = getFileExtension(file.name);
            return isAllowedExtension(fileExtension);
        });
    
        if (validFiles.length === 0) {
            errorMessage.classList.remove("hidden");
            dropZoneElement.classList.remove("drop-zone-over");
            return;
        }
    
        errorMessage.classList.add("hidden");
        for (let i = 0; i < validFiles.length; i++) {
    
            var f = files[i];
            refundDt.items.add(f);
            var rand = (Math.random() + 1).toString(36).substring(7);
            refundObj[rand] = f;
    
            const fileDiv = document.createElement("div");
            fileDiv.classList.add("file-container");
            const fileElement = createFileElement(validFiles[i]);
            const closeButton = document.createElement("button");
            closeButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M8 3C8 2.44772 8.44772 2 9 2H15C15.5523 2 16 2.44772 16 3C16 3.55228 15.5523 4 15 4H9C8.44772 4 8 3.55228 8 3ZM4.99224 5H3C2.44772 5 2 5.44772 2 6C2 6.55228 2.44772 7 3 7H4.06445L4.70614 16.6254C4.75649 17.3809 4.79816 18.006 4.87287 18.5149C4.95066 19.0447 5.07405 19.5288 5.33109 19.98C5.73123 20.6824 6.33479 21.247 7.06223 21.5996C7.52952 21.826 8.0208 21.917 8.55459 21.9593C9.06728 22 9.69383 22 10.4509 22H13.5491C14.3062 22 14.9327 22 15.4454 21.9593C15.9792 21.917 16.4705 21.826 16.9378 21.5996C17.6652 21.247 18.2688 20.6824 18.6689 19.98C18.926 19.5288 19.0493 19.0447 19.1271 18.5149C19.2018 18.006 19.2435 17.3808 19.2939 16.6253L19.9356 7H21C21.5523 7 22 6.55228 22 6C22 5.44772 21.5523 5 21 5H19.0078C19.0019 4.99995 18.9961 4.99995 18.9903 5H5.00974C5.00392 4.99995 4.99809 4.99995 4.99224 5ZM17.9311 7H6.06889L6.69907 16.4528C6.75274 17.2578 6.78984 17.8034 6.85166 18.2243C6.9117 18.6333 6.98505 18.8429 7.06888 18.99C7.26895 19.3412 7.57072 19.6235 7.93444 19.7998C8.08684 19.8736 8.30086 19.9329 8.71286 19.9656C9.13703 19.9993 9.68385 20 10.4907 20H13.5093C14.3161 20 14.863 19.9993 15.2871 19.9656C15.6991 19.9329 15.9132 19.8736 16.0656 19.7998C16.4293 19.6235 16.7311 19.3412 16.9311 18.99C17.015 18.8429 17.0883 18.6333 17.1483 18.2243C17.2102 17.8034 17.2473 17.2578 17.3009 16.4528L17.9311 7ZM10 9.5C10.5523 9.5 11 9.94772 11 10.5V15.5C11 16.0523 10.5523 16.5 10 16.5C9.44772 16.5 9 16.0523 9 15.5V10.5C9 9.94772 9.44772 9.5 10 9.5ZM14 9.5C14.5523 9.5 15 9.94772 15 10.5V15.5C15 16.0523 14.5523 16.5 14 16.5C13.4477 16.5 13 16.0523 13 15.5V10.5C13 9.94772 13.4477 9.5 14 9.5Z" fill="white"/></svg>`;
            closeButton.classList.add("close-button");
            closeButton.addEventListener("click", () => {
            fileToDelete = fileDiv;
            });
            fileDiv.appendChild(fileElement);
            fileDiv.appendChild(closeButton);
            fileContainer.appendChild(fileDiv);
        }
        $('#refundImg')[0].files = refundDt.files;
        }
    
        dropZoneElement.classList.remove("drop-zone-over");
    });
    
    });
    function createFileElement(file) {
        const fileElement = document.createElement("div");
        const allowedExtensions = ["jpg", "jpeg", "jfif" , "pjpeg" , "pjp" ,"png", "gif", "docx", "doc", "xls", "xlsx", "csv", "pdf"];
        
        if (file.type && file.type.startsWith("image/") && allowedExtensions.includes(getFileExtension(file.name))) {
            const imgElement = document.createElement("img")
            imgElement.src = URL.createObjectURL(file);
            imgElement.classList.add("w-20","h-20","rounded");
            fileElement.appendChild(imgElement);
        } else if (allowedExtensions.includes(getFileExtension(file.name))) {
            const fileExtension = getFileExtension(file.name);
        
            if (fileExtension) {
                const fileTypeIcon = getFileTypeIcon(fileExtension);
                fileElement.appendChild(fileTypeIcon);
            } else {
                const fileTypeIcon = document.createElement("div");
                fileTypeIcon.classList.add("file-icon");
                fileTypeIcon.textContent = "Unknown";
                fileElement.appendChild(fileTypeIcon);
            }
        } else {
            const fileTypeIcon = document.createElement("div");
            fileTypeIcon.classList.add("file-icon");
            fileTypeIcon.textContent = "Not Allowed";
            fileElement.appendChild(fileTypeIcon);
        }
        
        return fileElement;
    }
    function getFileTypeIcon(fileExtension) {
        if (fileExtension) {
            const iconElement = document.createElement("div");
            iconElement.classList.add("file-icon");
            iconElement.textContent = `.${fileExtension}`;
            return iconElement;
        } else {
            const iconElement = document.createElement("div");
            iconElement.classList.add("file-icon");
            iconElement.textContent = "Unknown";
            return iconElement;
        }
    }
    
    function getFileExtension(filename) {
        if (filename) {
            const parts = filename.split(".");
            if (parts.length > 1) {
            return parts[parts.length - 1];
            }
        }
        return null;
    }
    
    $(document).on('click', '.close-button', function() {
        var file_key = $(this).siblings('.r-img').attr('data-file');
        var file = refundObj.file_key;
        refundDt.items.remove(file);
        $('#refundImg')[0].files = refundDt.files;
        $(this).closest('div.file-container').remove();
    })
}

//## Download
if ($('#customer_download').length) {
    if (isFound) {
        $('#downloadData').removeClass('display-none');
    } else {
        $('#downloadData').addClass('display-none');
    }   
}

//## Notification
if ($('#user_notification_container').length) {
    $(document).on('click', '.marked-action', function (e) {
        var id = $(this).data('id');
        var isRead = $(this).find('img').attr('src').includes('icon-eye-off');

        handleNotificationAction($(this), id, isRead);
    });
    
    function handleNotificationAction(parent, id, isRead, title) {
        parent.css("pointer-events", "none");
        var addIconClass = isRead ? 'icon-eye' : 'icon-eye-off';
        var removeIconClass = isRead ? 'icon-eye-off' : 'icon-eye';
        var url = isRead ? markReadUrl : markUnreadUrl;
    
        $.ajax({
            url: url + id,
            type: 'patch',
            dataType: "json",
            data: {
                _token: token
            },
            success: function (data) {
                if (data === 1) {
                    parent.css("pointer-events", "all");
    
                    if ($('#user_notification_container').length) {
                        parent.find('img').attr('src', function (i, src) {
                            return src.replace(removeIconClass, addIconClass);
                        });
                    } else {
                        parent.attr('data-bs-original-title', title);
                        parent.find('i').toggleClass(removeIconClass + ' ' + addIconClass);
                        
                        $(parent).tooltip('dispose').tooltip('show');
                    }
                }
            },
        });
    }
}

//## Profile
if ($('#user_profile').length) {
    $(".open-modal").on('click', function() {
        $(".delete-modal").css("display", "flex");
        $(".delete-modal-container").show();
    });
    
    $('.close-btn').on('click', function() {
        $(".delete-modal").hide();
    });
    $('.genderSelect').select2();
    
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            proPic.src = URL.createObjectURL(file)
        }
    }
}

//## Wishlist
if ($('#customer_wishlists').length) {
    var wishlistClick = 0;
    $(document).on('click', '.wishlist', function() {
        if (++wishlistClick > 1) {
            return false;
        }

        var item_id = $(this).data('id');
        document.cookie = "product_id="+ item_id;
        var wishlist = $(this);

        var svg = $(this).html();
        setTimeout(() => {
            $(this).html(`
            <svg class="animate-spin text-gray-700 w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
                <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        `)
        }, 5);
        $.ajax({
            url: SITE_URL + "/myaccount/wishlist/store",
            type: 'POST',
            dataType: 'JSON',
            data:{
                product_id: item_id,
                "_token": token
            },
            success: function (data) {
                document.cookie = "product_id=; Max-Age=-99999999;";
                if ($(svg).hasClass('text-gray-10')) {
                    svg = svg.replace('text-gray-10', 'color_fill svg-bg')
                    $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) + 1);
                    $('#totalWishlistItem').addClass('w-4 h-4');
                } else if ($(svg).hasClass('color_fill')) {
                    svg = svg.replace('color_fill svg-bg', 'text-gray-10')
                    $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) - 1);
                    if ($('#totalWishlistItem').text() == 0) {
                        $('#totalWishlistItem').text('');
                        $('#totalWishlistItem').removeClass('w-4 h-4');
                    }
                } else if (wishlist.find('.fa-heart-o').length) {
                    wishlist.find('i').removeClass('fa-heart-o text-black');
                    wishlist.find('i').addClass('fa-heart text-green-500')
                    wishlist.find('span').text(jsLang('Remove from wishlist'));
                    $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) + 1);
                } else if (wishlist.hasClass('add-wishlist')) {
                    wishlist.addClass('remove-wishlist primary-bg-color');
                    wishlist.removeClass('add-wishlist');
                    $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) + 1);
                    $('#totalWishlistItem').addClass('w-4 h-4');
                } else if (wishlist.hasClass('remove-wishlist')) {
                    wishlist.addClass('add-wishlist');
                    wishlist.removeClass('remove-wishlist primary-bg-color');
                    $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) - 1);
                    if ($('#totalWishlistItem').text() == 0) {
                        $('#totalWishlistItem').text('');
                        $('#totalWishlistItem').removeClass('w-4 h-4');
                    }
                }
                else {
                    wishlist.find('i').removeClass('fa-heart text-gray-10')
                    wishlist.find('i').addClass('fa-heart-o text-black');
                    wishlist.find('span').text(jsLang('Add to wishlist'));
                    $('#totalWishlistItem').text(Number($('#totalWishlistItem').text()) - 1);
                    if ($('#totalWishlistItem').text() == 0) {
                            $('#totalWishlistItem').text('');
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                if (xhr.status == '401') {
                    window.location.href = SITE_URL + "/user/login";
                }
            },
            complete: function() {
                wishlist.html(svg);
                wishlistClick = 0
            }
        })
    })

    /** Shop Profile start **/
    $('.shop-search-icon').on('click', function() {
        if (window.innerWidth <= 624) {
            $(".search-in-store").toggle();
            $(".shop-menu").toggle();
        }
    });
    /** Shop Profile end **/

    // Prevent multiple click on delete button;
    var clickCount = 0;
    function preventMultipleClick() {
        if (++clickCount > 1) {
            return false;
        }
    }
}

//## Compare
if ($('#customer_wishlists').length) {
    emptyShow();
    $(document).on('click', '.add-to-compare', function() {
        let itemId = $(this).attr('data-itemId');
        compareAjaxCall("/compare-store", itemId, this);
    });

    $(document).on('click', '.compare-remove', function() {
        let itemId = $(this).attr('data-itemId');
        compareAjaxCall("/compare-delete", itemId, this);
    });

    var compareClick = 0;
    function compareAjaxCall(url, itemId, parent)
    {
        if (++compareClick > 1) {
            return false;
        }

        var svg = $(parent).html();
        setTimeout(() => {
            $('div[data-itemid=' + itemId +']').html(`
            <svg class="animate-spin text-gray-700 w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="#000" stroke-width="3"></circle>
                <path class="opacity-75" fill="#fff" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        `)
        }, 5);

        $.ajax({
            url: SITE_URL + url,
            data: {
                product_id: itemId,
                "_token": token
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 1) {
                    updateCompare(data.totalProduct, itemId);
                    if (url == '/compare-store') {
                        $('div[data-itemid=' + itemId +']').addClass('compare-remove').removeClass('add-to-compare');
                    } else {
                        $('div[data-itemid=' + itemId +']').addClass('add-to-compare').removeClass('compare-remove');
                    }
                }
            },
            complete: function() {
                $('div[data-itemid=' + itemId +']').html(svg);
                compareClick = 0
            }
        });
    }

    function emptyShow(itemId = null)
    {
    if (parseInt($('#totalCompareItem').text()) > 0 ) {
        $('.value-'+itemId).remove();
        $('#compareEmpty').hide();
        $('.compare-table').removeClass('display-none');
    } else {
        $('.compare-table').remove();
        $('#compareEmpty').show();
        $('#totalCompareItem').removeClass('w-4 h-4');
    }
    }

    function updateCompare(total = 0, itemId)
    {
        if (parseInt(total) > 0) {
            $('#totalCompareItem').html(total);
            $('#totalCompareItem').addClass('w-4 h-4');
        } else {
            $('#totalCompareItem').html('');
        }
        emptyShow(itemId);
    }

}

//## Sidebar
function toggleSideNav() {
    let collapse_icon = document.querySelector('.collapse-icon');
    let close = document.querySelector('.custom-close');
    let sidenavbar = document.querySelector('#sidenavbar');
    let overlay = document.querySelector('#overlay');

    let classOpen = [sidenavbar, overlay];

    collapse_icon.addEventListener('click', function(e) {
        classOpen.forEach(el => el.classList.add('active'));
    });

    let classCloseClick = [overlay, close];
    classCloseClick.forEach(function(el) {
        el.addEventListener('click', function(els) {
            classOpen.forEach(el => el.classList.remove('active'));
        });
    });
}

function checkWindowWidth() {
    if (window.innerWidth < 992) {
        toggleSideNav();
    }
}

checkWindowWidth();
window.addEventListener('resize', function() {
    checkWindowWidth();
});
