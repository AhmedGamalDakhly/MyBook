//JQUERY coding
$(document).ready(function(){


    $(".chat-box").click(function(){
		$(".chat-app").toggle();
	});

    $('.chat-messages').scrollTop(300000);

/*
    $(".chat-form.send-message").submit(function (e) {
        e.preventDefault();
        var targetURL='/MyBook/public/messanger/sendMessage';
        var myForm=new FormData(this);
        $(".text-box").attr('value',"message sent")
        $.ajax({
            url: targetURL,
            method: 'post',
            data: myForm,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var status=response.requestStatus;
                console.log(status);
                if (status=='success'){
                    console.log('message sent');
                    window.location.reload();
                }
            }
        });
    });
*/
});
