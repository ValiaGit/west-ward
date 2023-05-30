var Popup = {

    open:function(message) {
        $('.message_content').html(message);
        $('#modal_message').modal('show');
    }

};