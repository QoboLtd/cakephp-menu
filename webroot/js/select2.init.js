(function ($) {
    $('.select2').select2({
        theme: 'bootstrap',
        width: '100%',
        placeholder: '-- Please choose --',
        escapeMarkup: function (text) {
            return text;
        }
    });
})(jQuery);