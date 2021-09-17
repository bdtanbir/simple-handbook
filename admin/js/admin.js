(function($) {
    "use strict";

    $(document).ready(function() {
        // $(".shb-radio-input").change(function() {
        //     var that = this;
        //     $.post(shb_ajax_obj.ajaxurl, {
        //         acion: "shb_tag_count",
        //         title: this.value
        //     }, function(data) {
        //         that.nextSibling.remove();
        //         $(that).after(data);
        //     })
        // })

        $('.shb-radio-input').on('heartbeat-send', function(event, data) {
            // Add additional data to Heartbeat data.
            data.shb_customfield = 'some_data';
            alert(data);
        });
    })

})(jQuery);