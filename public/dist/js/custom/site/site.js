"use strict";

$(document).ready(function() {
    $('.custom-design-container').hide();
    $('.loading-dots').hide();

    let pageLoaded = false;

    function setSearchData(id, data) {
        if (data == '') {
            $(id).closest('.parent-search-section').hide();
            return;
        }
        $('.custom-design-container').show();
        $(id).closest('.parent-search-section').show()
        $(id).html(data);
    }
    // Function to generate the Popular Suggestions section
    function generatePopularSuggestions(data) {
        let suggestion = '';
        data.forEach(item => {
            suggestion += `<li><a href="${SITE_URL + '/search-products?keyword=' + item}" class="text-[13px] text-gray-12 font-medium line-clamp-1 px-3">${item}</a></li>`;
        });
        
        setSearchData('#popular_suggestions_list', suggestion);
    }
    
    // Function to generate the Popular Categories section
    function generatePopularCategories(data) {
        let categories = '';
        for (const key in data) {
            categories += `<li><a href="${SITE_URL + '/search-products?categories=' + key}" class="text-[13px] text-gray-12 font-medium line-clamp-1 px-3">${data[key]}</a></li>`;
        }
        
        setSearchData('#category_suggestion_list', categories);
    }
    
    function generateSearchProduct(data) {
        let products = '';
        data.forEach(item => {
            products += `<li>
                <a href="${SITE_URL + '/products/' + item.slug}">
                    <div class="flex gap-3 px-3 py-2">
                        <img class="w-[40px] object-cover rounded" src="${item.image}">
                        <div>
                        <p class="text-[13px] text-gray-12 font-medium line-clamp-1">${item.title}</p>
                        <span class="text-[13px] text-gray-12">${item.price}</span>
                        </div>
                    </div>
                </a>
            </li>`;
            });
            
        setSearchData('#product_search_list', products);
    }
    
    function generateSearchShop(data) {
        let shops = '';
        data.forEach(item => {
            shops += `<li>
                    <a href="${SITE_URL + '/shop/' + item.alias}">
                        <div class="flex gap-3 py-2 px-3">
                            <img class="w-[40px] h-[40px] object-cover rounded-full" src="${item.image}" alt="avatar">
                            <div>
                            <p class="text-[13px] text-gray-12 font-medium line-clamp-1">${item.title}</p>
                            <span class="text-[13px] text-gray-10"> Phone: ${item.phone}</span>
                            </div>
                        </div>
                    </a>
                </li>`;
        });
            
        setSearchData('#shop_search_list', shops);
    }
    

    // Function to fetch data and show loader only on page load
    function fetchDataOnPageLoad() {
        if (!pageLoaded && $('#itemSearch').val().length) {
            $('.loading-dots').show();
            
            $.ajax({
                url: SITE_URL + "/get-search-data",
                dataType: "json",
                type: "POST",
                data: {
                    _token: token,
                    search: $('#itemSearch').val(),
                },
                success: function(data) {
                    $('.loading-dots').hide();

                    if (data.status == 1) {

                        let parseData = JSON.parse(data.searchData);

                        if (parseData.popularSuggestion.length === 0 &&
                            parseData.popularCategories.length === 0 &&
                            parseData.products.length === 0 &&
                            parseData.shops.length === 0) {
                                
                            $('.not-found-content').text($('#itemSearch').val());
                            $('.parent-search-section').hide();
                            $('.empty-search').show();


                        } else {
                            generatePopularSuggestions(parseData.popularSuggestion);
                            generatePopularCategories(parseData.popularCategories);
                            generateSearchProduct(parseData.products);
                            generateSearchShop(parseData.shops);
                            $('.empty-contnet').hide();
                            $('.empty-search').hide();
                        }
                    } else {
                        $('.parent-search-section').hide();
                    }
                },
                error: function() {
                    $('.parent-search-section').hide();
                },
                complete: function() {
                    $('.loading-dots').hide();
                }
            });

            pageLoaded = true;
        }
    }

    // Show the custom design on search bar focus
    $("#itemSearch").on('click', function() {
        if ($('#itemSearch').val().length) {
            $('.custom-design-container').show();
            fetchDataOnPageLoad(); 
        }
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('#itemSearch').length && !$(event.target).closest('.custom-design-container').length) {
            $('.custom-design-container').hide();
        }
    });
    
    $('.custom-design-container').on('click', function(event) {
        event.stopPropagation();
    });
    
    
    $("#itemSearch").on('keyup', function() {
        pageLoaded = false;
        if ($(this).val().length === 0) {
            $('.custom-design-container').hide();
        } else {
            $('.custom-design-container').show();
        }
    })

    $("#itemSearch").autocomplete({
        delay: 500,
        position: { my: "left top", at: "left bottom", collision: "flip" },
        source: function(request, response) {
            fetchDataOnPageLoad(); 
        },
        select: function(event, ui) {
            let e = ui.item;
            window.location.href = SITE_URL + "/search-products?keyword=" + encodeURI(e.value).replace(/%20/g, "+");
        },
        minLength: 0,
        autoFocus: false
    });
});

$(document).ready(function() {
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
    }
    $('.custom-modal-over .close-modal').each(function() {
        var popupName = $(this).attr('data-popupName');
        var loginRequired = $(this).attr('data-loginRequired');
        var isLogin = $(this).attr('data-isLogin');
        var popupShowAfter = $(this).attr('data-popupShowAfter');
        var popupPage = $(this).attr('data-popupPage');

        if (!getCookie(popupName) && popupPage == 'true') {
            if (loginRequired == '1') {
                if (isLogin == 'true') {
                    setTimeout(() => {
                        $(this).closest('.custom-modal-over').show();
                    }, popupShowAfter * 1000);
                }
            } else {
                setTimeout(() => {
                    $(this).closest('.custom-modal-over').show();
                }, popupShowAfter * 1000);
            }
        }

        $('.custom-modal-over .close-modal').on('click', function() {
            $(this).closest('.custom-modal-over').hide();
        });

        $('.custom-modal-over .close-popup-window').on('click', function() {
            setTimeout(() => {
                $(this).closest('.custom-modal-over').hide();
            }, 5000);
            setCookie(popupName, true, 1);
        });
    });
})

$(document).on('submit', '#subscribe', function(e) {
    e.preventDefault();
    $('.send-btn').css('display', 'none');
    $('.subscribe-loader').css('display', 'inline');
    $('.subscribe-message').text('');
    $.ajax({
        type: 'post',
        url: subscribeUrl,
        data: new FormData(this),
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            $('.subscribe-message').text(data.message);
            $('.subscribe-loader').css('display', 'none');
            $('.send-btn').css('display', 'block');
        },
        error: function (data) {
            $('.subscribe-message').text(data.responseJSON.errors.email[0]);
            $('.subscribe-loader').css('display', 'none');
            $('.send-btn').css('display', 'block');
        }
    })
})

$(document).ready(function() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-start',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    if (sessionFail != '') {
       Toast.fire({
            icon: 'error',
            title: sessionFail
        })
    }

    if (sessionSuccess != '') {
       Toast.fire({
            icon: 'success',
            title: sessionSuccess
        })
    }

    $('.menu.dropdown-enable').each(function() {
        if ($(this).find('button .primary-bg-color').length > 0) {
            $(this).closest('li').find('a').first().addClass('active-border-bottom');
        }
    })
})

// for blog post sidebar archieve accordion

let titles = document.querySelectorAll('.accordion__header');
for (let i = 0; i < titles.length; i++) {
    titles[i].addEventListener('click', e => {
        for (let x of titles) {
            if (x !== e.target) {
                x.classList.remove('accordion__header--active');
                x.nextElementSibling.style.maxHeight = 0;
                x.nextElementSibling.style.padding = 0;
            }
        }
        e.target.classList.toggle('accordion__header--active');
        let description = e.target.nextElementSibling;

        if (e.target.classList.contains('accordion__header--active')) {
            description.style.maxHeight = description.scrollHeight + 'px';
        } else {
            description.style.maxHeight = 0;
            description.style.padding = 0;
        }
    });
}

function categoryLoader() {
    return `<div role="status">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin" viewBox="0 0 100 101" fill="#000" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">` + jsLang('loading') + `...</span>
            </div>`;
}

var isLoadedWebCategories = false;
var isLoadedMobileCategories = false;

$('.category-list-decoration').on('mouseover', function() {
    if (isLoadedWebCategories) {
        return;
    }
    
    isLoadedWebCategories = true;
    
    $.ajax({
        type: 'get',
        url: SITE_URL + '/load-web-categories',
        beforeSend: function() {
            $('.category-list-decoration').append(`
                <ul class="bg-white border absolute top-0 ul-mr min-h-full w-63 ltr:border-l-0 ltr:right-1p rtl:border-r-0 rtl:left-1p">
                    <li class="flex items-center justify-center height-437p">
                        ${categoryLoader()}
                    </li>
                </ul>
                `);
        },
        success: function (data) {
            $('.category-menu-wrapper').html(data);
        },
        error: function (data) {
            isLoadedWebCategories = false;
        }
    })
});

$('.mobile-sidebar').on('click', function() {
    if (isLoadedMobileCategories) {
        return;
    }
    
    isLoadedMobileCategories = true;
    
    $.ajax({
        type: 'get',
        url: SITE_URL + '/load-mobile-categories',
        beforeSend: function() {
            $('.mobile-categories').html(`
                    <div class="flex items-center justify-center">
                        ${categoryLoader()}
                    </div>
                `);
        },
        success: function (data) {
            $('.mobile-categories').html(data);
        },
        error: function (data) {
            isLoadedMobileCategories = false;
        }
    })
});

function loadLoginModal() { 
    $('.open-login-modal').addClass('active');
    
    const svg = $('.open-login-modal').find("svg");
    var isDeepColor = true;
    var interval = null;
    
    $.ajax({
        url: loadLoginModalUrl,
        type: 'GET',
        beforeSend: function() {
            svg.find("path, circle").css({
                "transition": "stroke 0.5s ease"
            });

            interval = setInterval(() => {
                svg.find("path, circle").attr(
                    "stroke",
                    isDeepColor ? "#111" : "#898989"
                );
                isDeepColor = !isDeepColor;
            }, 500);
        },
        success: function(data) {
            $('.login-block').html(data);
            
            $('.open-login-modal').trigger('click');
            
            clearInterval(interval);
            svg.find("path, circle").attr("stroke", "#898989");
        },
        error: function(data) {
            clearInterval(interval);
            svg.find("path, circle").attr("stroke", "#898989");
            $('.open-login-modal').removeClass('active');
        }
    })
}

$('.open-login-modal').on('click', function() {
    if ($(this).hasClass('active')) {
        return;
    }
    
    loadLoginModal();
});

if (loginNeeded == 1) {
    loadLoginModal();
}

function loadLazyImages() {
    $(".lazy-image:not(.image-loaded)").each(function () {
        $(this).attr("src", $(this).data("src")).addClass("image-loaded");
    });
}

$(window).on("load", function () {
    loadLazyImages();
});
