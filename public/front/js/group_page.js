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

    $('#applyForm').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        var  groupID= $(this).attr('groupID');
        var targetURL='/MyBook/public/group/'+groupID+"/changeCover";
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
                console.log("change group cover JS");
                console.log(response.check);
                if(response.check=="success"){
                    $('#coverImg').attr("src",response.imgSrc);
                }
                else {
                    console.log('Request failed : '+response.error_msg);
                }
            },
            error: function(xhr, status, error) {
                console.log('xhr: ' + xhr);
                console.log('status: ' + status);
                console.log('error: ' + error);
            }
        });


        });


    $(".about-tab").click(function(e) {
        console.log('about tab clicked');
        var path="https://web.whatsapp.com/";
        $('.tab-frame').attr("src",path);
    });

    $(".members-tab").click(function(e) {
        console.log('members tab clicked');
        var path="public/groupPage";
        $('.tab-frame').attr("src",path);
    });
    });

