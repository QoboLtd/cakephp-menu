(function($) {
    'use strict';
    /**
     * Clear select options
     *
     * @param  string id        identifier
     * @param  bool exceptFirst flag to exclude first option
     */
    var clear = function(id, exceptFirst) {
        var option = 'option';
        if (exceptFirst === true) {
            option = 'option:gt(0)';
        }
        var options = $(id).find(option).remove().end();
    };

    /**
     * Another ajax function which populater
     *
     * @param  string id identifier
     */
    var ajax = function(id, url) {
        $.ajax({
            type: 'get',
            url: url,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            },
            success: function(response) {
                if (response.content) {
                    var i;
                    var $toPopulate = $(id);
                    clear($toPopulate, true);
                    for (i = 0; i < response.content.length; i++) {
                        $toPopulate.append('<option value="' + response.content[i].id + '">' + response.content[i].label + '</option>')
                    }
                }
            },
            error: function(e) {
                alert("An error occurred: " + e.responseText.message);
                console.log(e);
            }
        });
    };

    /**
     * Returns the url taken from the menus
     *
     * @return string
     */
    var getUrl = function() {
        return $('#menus').attr('rel') + '?id=' + $('#menus').val() + '&parents_only=1';
    };

    //Register the change event.
    $('#menus').change(function() {
        var url = $(this).attr('rel') + '?id=' + $(this).val() + '&parents_only=1';
        ajax('#fetch-menu-items', url);
    });

    //Run on load.
    ajax('#fetch-menu-items', getUrl());
})(jQuery);
