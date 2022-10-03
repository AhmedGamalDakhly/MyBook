//JQUERY coding
$(document).ready(function(){
    // new post section

    $('#modalBtn-cover').click(function(e){
        $('#myModal').show();
        $('#modal-header').html('Update Cover Photo');
        var imgSrc=$('#coverImg').attr('src');
        $('#modalPhoto').attr("src",imgSrc);
        $('#applyForm').attr("type",'cover');
    });

    $('#modalBtn-profile').click(function(e){
        $('#myModal').show();
        $('#modal-header').html('Update Profile Photo');
        var imgSrc=$('#profImg').attr('src');
        $('#modalPhoto').attr("src",imgSrc);
        $('#applyForm').attr("type",'profile');

    });
    $('.close-modal').click(function (e) {
        $('#myModal').hide();
    });
    $('.applyBtn').click(function (e) {
        $('#myModal').hide();
    });


    $("#uploadBtn").on('change', function() {
        console.log($(this)[0].files);
        const [file] = $(this)[0].files;
        if (file) {
            var path = URL.createObjectURL(file)
            $('#modalPhoto').attr("src",path);

        }
    });

    jQuery('#applyForm').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        var type=$(this).attr('type');
        var profileID=$(this).attr('profileID');
        console.log(profileID);
        var targetURL='/MyBook/public/profile/'+profileID+'/changeImg/'+type;
        $('#myModal').hide();
        $.ajax({
            url: targetURL,
            method: 'post',
            data:formData,
            contentType : false,
            processData : false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                var newSrc=response.newImgSrc;
                console.log(response.msg)
            if (type=='cover'){
                $('#coverImg').attr("src",newSrc);

            }else if(type=='profile'){
                $('.profile-image').attr("src",newSrc);
            }
            },
            error: function(xhr, status, error) {
                console.log('xhr: ' + xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            }
        });


        });
    });

