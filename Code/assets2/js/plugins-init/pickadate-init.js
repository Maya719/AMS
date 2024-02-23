(function($) {
    "use strict"

    $('.datepicker-default').daterangepicker({
        locale: {
            format: date_format_js
        },
        singleDatePicker: true,
    });

})(jQuery);