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

/*
    $('.add-friend').click(function (e) {
        var groupID=$(this).parents('.cards-group').attr('groupID');
        var  friendID= $(this).attr('id');
        var targetURL = "/MyBook/public/group/"+groupID+'/members/add/'+friendID;
        var thisBtn=$(this);
        $.ajax({
            url: targetURL,
            method: 'POST',
            data: {'friendID' : friendID},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                if(response.check=="success"){
                     thisBtn.text('added');
                    thisBtn.parents('.card-wrapper').remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });
    $('.remove-friend').click(function (e) {
        $(this).text('removed');
        $(this).parents('.card-wrapper').remove();
       // console.log();
    });

    $('.fire-friend').click(function (e) {
        var groupID=$(this).parents('.cards-group').attr('groupID');
        var  friendID= $(this).attr('id');
        var targetURL = "/MyBook/public/group/"+groupID+'/members/remove/'+friendID;
        var thisBtn=$(this);
        $.ajax({
            url: targetURL,
            method: 'POST',
            data: {'friendID' : friendID},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                if(response.check=="success"){
                    thisBtn.parents('.card-wrapper').remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });


    $('.reject-request').click(function (e) {
        var groupID=$(this).parents('.cards-group').attr('groupID');
        var  friendID= $(this).attr('id');
        var targetURL = "/MyBook/public/group/"+groupID+'/members/request/'+friendID+'/reject';
        var thisBtn=$(this);
        $.ajax({
            url: targetURL,
            method: 'POST',
            data: {'friendID' : friendID},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                if(response.check=="success"){
                    thisBtn.parents('.card-wrapper').remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });
    $('.approve-request').click(function (e) {
        var groupID=$(this).parents('.cards-group').attr('groupID');
        var  friendID= $(this).attr('id');
        var targetURL = "/MyBook/public/group/"+groupID+'/members/request/'+friendID+'/approve';
        var thisBtn=$(this);
        $.ajax({
            url: targetURL,
            method: 'POST',
            data: {'friendID' : friendID},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response.check);
                if(response.check=="success"){
                    thisBtn.parents('.card-wrapper').remove();
                    console.log(response.msg);
                }else{
                    console.log(response.msg);
                }
            }
        });
    });
*/
});
