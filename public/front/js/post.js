$(document).ready(function () {
    $('.delete-post').click(function (e) {
        var postID=$(this).attr('postid');
        var targetURL='/MyBook/public/delete';
        $.ajax({
            url: targetURL+postID,
            method: 'post',
            data: {},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var status=response.check;
                console.log(status);
                console.log(response.msg);
                if (status=='success'){
                    window.location.reload();
                }else if(status=='failed'){
                    window.location.replace("http://stackoverflow.com");
                }
            }
        });
    });
/*
    $('#addCommentForm').submit(function (e) {
      //  e.preventDefault();
        var postID=$(this).attr('postID');
        var targetURL='/MyBook/public/comment'+postID;
        var myForm=new FormData(this);
        $.ajax({
            url: targetURL,
            method: 'post',
            data: myForm,
            contentType:false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var status=response.check;
                console.log(response.check);
                console.log(response.msg);
                if (status=='success'){
                    window.location.reload();
                }else if(status=='failed'){
                   // window.location.replace("http://stackoverflow.com");
                }
            }
        });
        $(this).find("input[type=text], textarea").val("");
    });

    $('#addReplyForm').submit(function (e) {
       //e.preventDefault();
        var commentID=$(this).attr('commentID');
        var targetURL='/MyBook/public/reply'+commentID;
        var myForm=new FormData(this);
        $.ajax({
            url: targetURL,
            method: 'post',
            data: myForm,
            contentType:false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var status=response.check;
                console.log(status);
                if (status=='success'){
                    window.location.reload();
                }else if(status=='failed'){

                }
            }
        });
        $(this).find("input[type=text], textarea").val("");
    });
*/
    $('.post-actions .share').click(function (e) {
        console.log("share post");
        e.preventDefault();
        var  postID= $(this).parent().attr('contentID');
        var targetURL='/MyBook/public/share'+postID;
        $.ajax({
            url: targetURL,
            method: 'post',
            data: {
                'text' : 'comment on shared post',
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var status=response.check;
                console.log(response.check);
                console.log(response.msg);
                if (status=='success'){
                    window.location.reload();
                }else if(status=='failed'){
                    // window.location.replace("http://stackoverflow.com");
                }
            }
        });
        $(this).find("input[type=text], textarea").val("");
    });


});
