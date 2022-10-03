<!-- header  -->
<header class="fluid-container position ">
    <div class="main-header  row ">
        <div class="logo-search flex-row flex-center col-md-5 col-lg-3 ">
            <a class="logo-link" href="{{route('home.route')}}"><i class=" fab fa-facebook fa-3x"></i></a>
            <div class="search-box content-center">
                <i class="search-icon fas fa-search "></i>
                <input class="text-field" type="text" placeholder="Search Facebook" name="" />
            </div>
        </div>

        <div class="image_text-link flex-center-perfect col-4 col-md-3 order-md-3 order-lg-3 col-lg-2">
            <a href="{{route('profile.route')}}">
                <img class="image profile-image" src="{{asset($currentUserProfile['path'].$currentUserProfile['image'])}}" alt=""/>
                <span class="text">{{$currentUserProfile['name']}}</span>
            </a>
        </div>
        <div class="options col-8 col-md-4 order-md-2 order-lg-4 col-lg-3">
            <a href=""><i class="rect-icon option  fas fa-th"></i></a>
            <a class="chat-msg" href="{{route('chat.route',$chatID)}}"><i class="rect-icon option fab fa-facebook-messenger "><sup class="msg-bell @if(!$hasMsg) d-none @endif"><i class="fas fa-comment-dots"></i></sup></i></a>
            <a href="{{route('notifications.route')}}" class="notification-bell"><i class="rect-icon option fas fa-bell ">@if($myNotificationsCount > 0)<sup  id="notificationCount">{{$myNotificationsCount}}</sup>@endif</i></a>
            <a href="{{route('profile.settings.route')}}"><i class="rect-icon option fas fa-bars"></i></a>
        </div>
        <div class="tabs order-md-5 order-lg-2 col-lg-4">
            <a href="{{route('home.route')}}"><i class="rect-icon home-icon fas fa-home "></i></a>
            <a href="{{route('friends.route')}}"><i class="rect-icon friends-icon fas  fa-user-friends "></i></a>
            <a href=""><i class="rect-icon media-icon fas fa-play-circle "></i></a>
            <a href=""><i class="rect-icon store-icon fas fa-store"></i></a>
            <a href="{{route('groups.route')}}"><i class="rect-icon groups-icon fas fa-users "></i></a>
        </div>
    </div>
</header>
<!--end header-->
