@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}{{$layout}}/settings.css" />
@endsection
@section('content')
    <div class="content container" >
        <div class=" profile-settings ">
            <h1 class="page-head">Profile Settings</h1>
            <form class="flex-col flex-center-perfect" method="POST" action="{{route('profile.changeSettings.route')}}">
                @include('errors')
                @csrf
                <input class="text-field" type="text" placeholder="Name" name="name" value="{{$currentUserProfile['name']}}"/>
                <input class="text-field" type="text" placeholder="Phone Number" name="phone" value="{{$currentUserProfile['phone']}}"/>
                <input class="text-field" type="password" placeholder="Current Password" name="current_password" />
                <input class="text-field" type="password" placeholder="New Password" name="password"/>
                <input class="text-field" type="password" placeholder="Confirm Password" name="password_confirmation"/>
                <div class="lock">
                    <label >Profile Lock</label>
                    <select name="lock">
                        <option selected  >{!!  $currentUserProfile->settings()['lock'] !!}</option>
                        <option  >on</option>
                        <option  >off</option>
                    </select>
                </div>
                <div class="layout">
                    <label >Layout</label>
                    <select name="layout">
                        <option selected  >{{$currentUserProfile->settings()['layout']}}</option>
                        <option  >Light</option>
                        <option  >Dark</option>
                    </select>
                </div>

                <hr/>
                <button class="button apply-btn" type="submit"  name="apply">Apply Settings</button>
            </form>
        </div>

    </div>
@endsection
