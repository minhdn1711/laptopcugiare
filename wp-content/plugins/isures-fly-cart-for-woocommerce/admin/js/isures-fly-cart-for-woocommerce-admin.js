(function($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    if ($('.color-primary').length > 0) {
        $('.color-primary').wpColorPicker();
    }
    // submit form ajax
    $('body').on('click', '.isures-setting--wrap input[name="submit_option"]', function() {

        var data = $(this).closest('.isures-build--inner').find('form');
        $.ajax({
            method: 'POST',
            url: ajaxurl,
            data: data.serialize(),
            dataType: 'HTML',
            beforeSend: function() {
                $('.isures-progress--wrap').addClass('active');
            },
            success: function(resp) {
                $('.isures-progress--saving').css('width', '100%');
                $('.isures-notice--update').fadeIn();
                setTimeout(function() {
                    $('.isures-notice--update').fadeOut();
                }, 2000);

                $('.isures-progress--wrap').removeClass('active');
            }
        });
        return false;

    });
})(jQuery);