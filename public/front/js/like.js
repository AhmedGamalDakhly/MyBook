//JQUERY coding
$(document).ready(function() {
    // new like section

    // like button

    $('.post-actions .like').click(function (e) {
        e.preventDefault();
        var  contentID= $(this).parent().attr('content-id');
        var targetURL = "/MyBook/public/like"+contentID;
        var thisBtn=$(this);
        $.ajax({
            url: targetURL,
            method: 'POST',
            data: {'contentID' : contentID},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                console.log('isLiked : ' + response.isLiked);
                if(response.check=="success"){
                    if(response.isLiked==true){
                        thisBtn.addClass('liked');
                    }else{
                        thisBtn.removeClass('liked');
                    }
                }
                else {
                    console.log('Request failed : ' +response.msg);
                }
            },
            error: function(xhr, status, error) {
                console.log('xhr: ' + xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            }
        });
    });

    $('.comment-actions .like').click(function (e) {
        e.preventDefault();
        var  contentID= $(this).parent().attr('contentID');
        var targetURL = "/MyBook/public/like"+contentID;
        var thisBtn=$(this);
        $.ajax({
            url: targetURL,
            method: 'POST',
            data: {'contentID' : contentID},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                console.log('isLiked : ' + response.isLiked);
                if(response.check=="success"){
                    if(response.isLiked==true){
                        thisBtn.addClass('liked');

                    }else{
                        thisBtn.removeClass('liked');
                    }
                }
                else {
                    console.log('Request failed : '+response.error_msg);
                }
            }
        });
    });



});
