(function ($) {
    $('#item-type').on('select2:select', function (event) {
        $('#type-inner-container>#item-custom').detach().prependTo('#type-outer-container');
        $('#type-inner-container>#item-module').detach().prependTo('#type-outer-container');
        $('#type-outer-container>#item-' + this.value).detach().prependTo('#type-inner-container');
    });$('#item-type').on('select2:unselect', function (event) {
        $('#type-inner-container>#item-custom').detach().prependTo('#type-outer-container');
        $('#type-inner-container>#item-module').detach().prependTo('#type-outer-container');
    });
})(jQuery);