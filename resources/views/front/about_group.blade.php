@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}/group_page.css"  />
    <link rel="stylesheet" href="{{asset('front/css')}}/modal.css"  />
@endsection
@section('content')
    <div class="group-header">
        <div class="cover-setcion container">
            <img class="cover-photo" id="coverImg" src="{{asset($group['path'].$group['cover'])}}" alt="" />
            @if($currentUserProfile['user_id']===$group['owner'])
                <button id="modalBtn-cover" data="cover" class="image-btn edit-btn btn-position">
                    <i class="fas fa-camera"></i>
                    <span class="d-none d-md-inline-block ">Edit Cover Photo</span>
                </button>
            @endif
        </div>
        <div class="profile-info container ">

            <h1 class="group-name">{{$group['name']}}</h1>
            <h1 class="group-info">{{$group['type']}} <span> . {{$group['members_count']}} member</span></h1>
            <div class="options col-lg-4">
                <button class="add_story-btn"><i class="fas fa-plus-circle"></i>Join</button>
            </div>

        </div>
    </div>
    <div class="content container">
            <div class="left-section flex-col col-lg-4 col-xl-5">
                <div class="intro  ">
                    <h1>Group Info</h1>
                    <p>{{$group['desc']}}</p>
                    <h4>From Minya Egypt</h4>
                    <button >Edit Details</button>
                    <hr/>
                    <div class="hobbies">
                        <a href="" class="link-button">Football Soccer</a>
                        <hr/>
                        <button >Edit Hobbies</button>
                    </div>
                    <button >Add Featured</button>
                </div>
                <div class="friends">
                </div>
            </div>
    </div>
@endsection
@section('js_links')
    <script src="{{asset('front/js')}}/group_page.js"></script>
    <script src="{{asset('front/js')}}/groups.js"></script>
@endsection
