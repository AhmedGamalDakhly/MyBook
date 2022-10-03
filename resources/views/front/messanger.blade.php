@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}{{$layout}}/chat.css" />
@endsection
@section('content')
        <div class="chat-app container">
            <h1 class="h3 ">Messages</h1>
            <div class="row g-0 ">
                    <div class="col-12 col-lg-4 col-xl-3 order-right  ">
                        <div class="px-4 d-none d-md-block">
                            <div class="d-flex align-items-center">
                                <div class="flex-col">
                                    <input type="text" class="form-control my-3" placeholder="Search...">
                                    @if(!empty($myFriends))
                                        @foreach($myFriends as   $friendProf)
                                            <a href="{{route('chat.route',$friendProf['user_id'])}}" class="list-group-item list-group-item-action border-0" userID="{{$friendProf['user_id']}}">
                                                <div class="flex-row flex-center-perfect">
                                                    <img src="{{asset($friendProf['path'].$friendProf['image'])}}" class="rounded-circle mr-1" alt="" width="40" height="40">
                                                    <div class="flex-grow-1 ml-3">
                                                        {{$friendProf['name']}}
                                                        @if(Cache::has('user-is-online-' .$friendProf['user_id']))
                                                            <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                                                        @else
                                                            <i class=" dot  far fa-circle"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    @endif
                                    <hr class="d-block d-lg-none mt-1 mb-0">
                                </div>
                            </div>
                        </div>

                    </div>
                @if($hasFriend)
                    <div class="col-12 col-lg-7 col-xl-9 div2">
                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                <a href="{{route('profile.route')}}" class="position-relative"  >
                                    <img src="{{asset($userProfile['path'].$userProfile['image'])}}" alt="" width="40" height="40">
                                </a>
                                <a href="{{route('profile.route')}}" class="flex-grow-1 pl-3">
                                    <strong>{{$userProfile['name']}}</strong>
                                    <div class="text-muted small"><em>Typing...</em></div>
                                </a>
                                <div>
                                    <button class="btn btn-primary btn-lg mr-1 px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone feather-lg"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></button>
                                    <button class="btn btn-info btn-lg mr-1 px-3 d-none d-md-inline-block"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video feather-lg"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg></button>
                                    <button class="btn btn-light border btn-lg px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-lg"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button>
                                </div>
                            </div>
                        </div>
                        <div class="position-relative">
                            <div class="chat-messages p-4">
                    @if(!empty($messages))
                        @foreach($messages as $message)
                            @if($message['sender']===$currentUserProfile['user_id'])
                                <div class=" pb-4 flex-col">
                                    <div>
                                        <div class="text-muted small text-nowrap mt-2">{{$message['created_at']}}</div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                        <div class="font-weight-bold mb-1">You</div>
                                        {{$message['text']}}
                                        @if($message['image']!=null)
                                            <img  class="message-image" src="{{asset($message['image'])}}"    alt="" >
                                        @endif
                                    </div>

                                </div>
                            @endif
                            @if($message['receiver']===$currentUserProfile['user_id'])
                                <div class="chat-message-left  pb-4">
                                    <div>

                                            <div class="text-muted small text-nowrap mt-2">{{$message['created_at']}}</div>
                                    </div>
                                    <div class="flex-shrink-1 message-received bg-light rounded py-2 px-3 ml-3">
                                        {{$message['text']}}
                                        @if($message['image']!=null)
                                            <img src="{{asset($message['image'])}}" class="message-image" alt="Chris Wood">
                                        @endif
                                    </div>
                                </div>
                            @endif
                                    @endforeach
                                @endif

                            </div>
                        </div>
                        <hr>
                        @include('errors')
                        <form class="chat-form send-message flex-row " method="POST" action="{{route('sendMessage.route')}}" enctype="multipart/form-data">
                            @csrf
                            <input class="text-box" type="text" class="form-control" placeholder="Type your message" name="text"/>
                            <input class=""  type="text"  id="reciever" hidden name="receiver" value="{{$userProfile['user_id']}}"/>
                            <div class="file-upload-wrapper ">
                                    <input class="upload-btn "  type="file"  id="uploadImg" name="msg_file"/>
                                    <label class="upload-label"  for="uploadImg" >
                                        <i class="label-icon fas fa-camera"></i>
                                    </label>
                                </div>
                            <input type="submit" class="btn btn-primary" name="send_msg" value="Send"/>
                        </form>
                    </div>
                @else
                    <div>
                        <h4>No Messages To show</h4>
                        <a class="btn btn-primary" href="{{route('friends.route')}}"> Add Friends To Start Chat </a>
                    </div>
                @endif
            </div>
        </div>
@endsection
@section('js_links')
    <script src="{{asset('front/js')}}/chat.js" ></script>
@endsection
