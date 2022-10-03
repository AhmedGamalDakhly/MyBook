//JQUERY coding
$(document).ready(function() {
    var addFriendUrl="/MyBook/public/friends/add/";
    $('button.add-friend').click(function (e) {
        var  friendID= $(this).attr('friend-id');
        var  targetURL = addFriendUrl+friendID;
        var thisBtn=$(this);
        var cardWrapper=$(this).parents('.card-wrapper');
        $.ajax({
            url: targetURL,
            method: 'POST',
            data: {},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                if(response.check=="success"){
                    thisBtn.text('Request Sent');
                    cardWrapper.remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });

    var unFriendUrl="/MyBook/public/friends/unFriend/";
    $('button.remove-friend').click(function (e) {
        var  friendID= $(this).attr('friend-id');
        var targetURL = unFriendUrl+friendID;
        var cardWrapper=$(this).parents('.card-wrapper');
        $.ajax({
            url: targetURL,
            method: 'POST',
            data: {},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                cardWrapper.remove();
                console.log(cardWrapper);
            }
        });
    });

    var approveRequestUrl="/MyBook/public/friends/requests/approve/";
    $('button.approve-request').click(function (e) {
        var  friendID= $(this).attr('friend-id');
        var targetURL = approveRequestUrl+friendID;
        var thisBtn=$(this);
        var cardWrapper=$(this).parents('.card-wrapper');

        $.ajax({
            url: targetURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                console.log(response.msg);
                if(response.check=="success"){
                    console.log(response.msg);
                    cardWrapper.remove();

                }else{
                    console.log(response.msg);
                }
            }
        });
    });

    var rejectRequestUrl="/MyBook/public/friends/requests/reject/";
    $('button.reject-request').click(function (e) {
        var  friendID= $(this).attr('friend-id');
        var targetURL = rejectRequestUrl+friendID;
        var thisBtn=$(this);
        var cardWrapper=$(this).parents('.card-wrapper');
        $.ajax({
            url: targetURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                console.log(response.msg);
                if(response.check=="success"){
                    console.log(response.msg);
                    cardWrapper.remove();
                }else{
                    console.log(response.msg);
                }
            }
        });
    });
});
