//JQUERY coding
$(document).ready(function() {
    var setNotificationSeen="/MyBook/public/notifications/setSeen/";
    $('.set-seen').click(function (e) {
        var  notificationID= $(this).attr('notification-id');
        var  targetURL = setNotificationSeen+notificationID;
        var notificationBox=$(this).parent();
        var thisBtn=$(this);
        $.ajax({
            url: targetURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                if(response.check=="success"){
                    thisBtn.remove();
                    notificationBox.removeClass('alert-warning');
                    var count= $('#notificationCount').html(function(i, origValue){
                        val= parseInt(origValue)-1;
                        if(val>0){
                            return val;
                        }
                        return "";
                    });
                }
                    console.log(response.msg);
            }
        });
    });


});
