/*global jQuery, document, redux*/

(function ($) {
    "use strict";


    var yeti_stylesheet = {};
    $(document).ready(function () {
        yeti_stylesheet.init();

        $(document).on('click', '#reset_stylesheet_button', function (e) {
            e.preventDefault();
            var _data = $('#yeti_stylesheet_reset_data').val(),
                _btn = $(this);
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'yesshop_reset_stylesheet',
                    scheme: _data
                },
                beforeSend: function () {
                    _btn.prop('disabled', true);
                },
                error: function (o) {
                    window.onbeforeunload = null;
                    window.location.reload(true);
                },
                success: function (o) {
                    window.onbeforeunload = null;
                    window.location.reload(true);
                }
            });
        });
    });

    yeti_stylesheet.init = function (selector) {

        if (!selector) {
            selector = $(document).find('.yeti_stylesheet-container:visible');
        }
        $(selector).each(
            function () {
                console.log(1000);
                var el = $(this);
                var parent = el;
                if (!el.hasClass('redux-field-container')) {
                    parent = el.parents('.redux-field-container:first');
                }
                if (parent.is(":hidden")) { // Skip hidden fields
                    return;
                }
                if (parent.hasClass('redux-field-init')) {
                    parent.removeClass('redux-field-init');
                } else {
                    return;
                }
                var default_params = {
                    width: 'resolve',
                    triggerChange: true,
                    allowClear: true
                };

                var select2_handle = el.find('.select2_params');
                if (select2_handle.size() > 0) {
                    var select2_params = select2_handle.val();

                    select2_params = JSON.parse(select2_params);
                    default_params = $.extend({}, default_params, select2_params);
                }

                el.find(".redux-select-item ").select2(default_params);


            }
        );


    };
})(jQuery);