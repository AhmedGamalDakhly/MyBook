    <!-- javascript code used to setup web sockets and establish connection to broadcast channels. -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            function playSound(url) {
                const audio = new Audio(url);
                audio.play();
            }

            Echo.private('chat-channel{{$currentUserProfile['user_id']}}')
                .listen('NewChatMessage', function (e) {
                    console.log('NewChatMessage created *****');
                    $('.msg-bell').removeClass('d-none');
                    var msg='<div class=\"chat-message-left  pb-4\"> ' +
                                 '<div>' +
                                     '<div class=\"text-muted small text-nowrap mt-2\">'+e.message["created_at"]+'</div>' +
                                '</div>' +
                                ' <div class=\"flex-shrink-1 message-received bg-light rounded py-2 px-3 ml-3\">'+
                                  e.text +
                             '</div>';
                      $('.chat-messages').append(msg);
                    console.log('NewChatMessage created *****');

                    $('.chat-messages').scrollTop(300000);
                    playSound("{{asset('front/sound/message.mp3')}}");
                });

            Echo.private('notification-channel{{$currentUserProfile['user_id']}}')
                .listen('NotificationEvent', function (e) {
                    console.log('NewChatMessage created *****');
                    var count= $('#notificationCount').html(function(i, origValue){
                        if(origValue==""){
                            console.log('NotificationEvent created *****');
                            return  1;
                        }
                        return parseInt(origValue)+1;
                    });
                    playSound("{{asset('front/sound/note.wav')}}");
                });
        });
    </script>


