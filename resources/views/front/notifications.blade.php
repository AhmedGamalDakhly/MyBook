@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}/notifications.css" />
@endsection
@section('content')
    <div class="notifications container mt-5">
        @if(!empty($myNotifications))
            @foreach($myNotifications as $notification)
                    <div class="notification @unless($notification['state']) alert-simple @endunless  alert-warning  text-left show" >
                        @unless($notification['state'])<i class="start-icon set-seen far fa-check-circle position" notification-id="{{$notification['id']}}"></i>@endif
                        <a href="{{route('notifications.content.route',$notification['id'])}}">
                            <strong class="font__weight-semibold">{{$notification['userName']." "}}</strong>
                            <strong class="font__weight-semibold">{{$notification['msg']." "}}</strong>
                            <strong class="font__weight-semibold">{{$notification['last']." "}}</strong>
                        </a>
                    </div>
                <hr/>
            @endforeach
        @endif
    </div>
@endsection
@section('js_links')
    <script src="{{asset('front/js')}}/notification.js" ></script>
@endsection
