document.addEventListener('DOMContentLoaded', function () {
    $('.select2-hide-search-custom').select2({
        minimumResultsForSearch: Infinity,
        templateResult: function (result) {
            if (!result.id) {
                return;
            }

            return $("<span><img class='me-2' width='20px' src=" + flags[result.id] + "/> " + result.text + "</span>");
        },
        templateSelection: function (result) {
            if (!result.id) {
                return;
            }

            return $("<span><img class='me-2' width='20px' src=" + flags[result.id] + "/> " + result.text + "</span>");
        }
    });
});
