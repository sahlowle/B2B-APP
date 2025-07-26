"use strict";

$(document).on("click", "#payment-link", copyURL);

function copyURL() {
    var copyText = $(this).attr('data-route');

    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText);
    $(this).text(jsLang('Copied'));
}
