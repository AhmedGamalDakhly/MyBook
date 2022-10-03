//JQUERY coding
$(document).ready(function() {
    // new post section
    $(".hidden").hide();
    $("#newpost-text").focus(function () {
        $("#newpost-text").animate({height: '100px'}, "slow");
        $(".hidden").fadeIn("slow");
        $(".hidden").animate({right: '100px'}, "slow");

    });

    // like button

    $('.join-group').click(function (e) {
        var  groupID= $(this).attr('group-id');
        var card= $(this).parents('.group-card');
        var targetURL = "/MyBook/public/group/"+groupID+"/members/requestJoin";
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
                    card.remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });

    $('button.approve-request').click(function (e) {
        var  memberID= $(this).attr('login-id');
        var card= $(this).parents('.cards-group');
        var  groupID= $(this).attr('group-id');
        var targetURL = "/MyBook/public/group/"+groupID+"/members/acceptRequest/"+memberID;
        $.ajax({
            url: targetURL,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                if(response.check=="success"){
                    card.remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });
    $('button.reject-request').click(function (e) {
        var  memberID= $(this).attr('login-id');
        var card= $(this).parents('.cards-group');
        var  groupID= $(this).attr('group-id');
        var targetURL = "/MyBook/public/group/"+groupID+"/members/rejectRequest/"+memberID;
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
                    thisBtn.text(response.msg);
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });
    $('button.remove-member').click(function (e) {
        var  memberID= $(this).attr('login-id');
        var card= $(this).parents('.card-wrapper');
        var  groupID= $(this).attr('group-id');
        var targetURL = "/MyBook/public/group/"+groupID+"/members/remove/"+memberID;
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
                    card.remove();
                    console.log(response.msg);
                }
            }
        });
    });

    $('button.invite-member').click(function (e) {
        var  memberID= $(this).attr('login-id');
        var  groupID= $(this).attr('group-id');
        var targetURL = "/MyBook/public/group/"+groupID+"/members/invite/"+memberID;
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
                    thisBtn.text(response.msg);
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });
    $('button.accept-invite').click(function (e) {
        var  memberID= $(this).attr('login-id');
        var  groupID= $(this).attr('group-id');
        var card= $(this).parents('.group-box');
        var targetURL = "/MyBook/public/group/"+groupID+"/members/acceptInvite";
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
                    card.remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });
    $('button.reject-invite').click(function (e) {
        var  memberID= $(this).attr('login-id');
        var  groupID= $(this).attr('group-id');
        var card= $(this).parents('.group-box');
        var targetURL = "/MyBook/public/group/"+groupID+"/members/rejectInvite";
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
                    card.remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });

    $('button.exit-group').click(function (e) {
        var  groupID= $(this).attr('group-id');
        var card= $(this).parents('.group-box');
        var targetURL = "/MyBook/public/group/"+groupID+"/members/exit";
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
                    thisBtn.text(response.msg);
                    card.remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });

    $('button.cancel-request').click(function (e) {
        var  memberID= $(this).attr('login-id');
        var card= $(this).parents('.group-box');
        var  groupID= $(this).attr('group-id');
        var targetURL = "/MyBook/public/group/"+groupID+"/members/cancelJoinRequest";
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
                    card.remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });

    $('button.delete-group').click(function (e) {
        var  groupID= $(this).attr('group-id');
        var card= $(this).parents('.group-box');
        var targetURL = "/MyBook/public/group/"+groupID+"/delete";
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
                    thisBtn.text(response.msg);
                    card.remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });

});
