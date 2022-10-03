@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}{{$layout}}/groups.css"  />
@endsection
@section('content')
	<div class="content groups-page container-fluid">
        <div class="row">
            <div class="left-section col-3  d-none d-xl-block ">
                <div class="additional-options flex-col">
                    <h1>Groups</h1>
                    <form class="search-box">
                        <i class="search-icon fas fa-search "></i>
                        <input class="text-field" type="text" placeholder="Search a Group" name="" />
                    </form>
                    <a  href="{{route('groups.newGroupForm.route')}}" class="add-group" >
                        <i class="plus-icon fas fa-plus-circle"> </i>
                        Create a New Group
                    </a>
                    <hr>

                </div>
            </div>

            <div class="main-section  col-lg-6 col-xl-6">
                <div class="my-groups">
                    <h3>Groups You've Joined</h3>
                    @if(!empty($joinedGroups))
                        @foreach($joinedGroups as $group)
                            <div class="group-box flex-row">
                                <a href="{{route('group.route',$group['id'])}}" class="group-link flex-row">
                                    <img class="image" src="{{asset($group['path'].$group['cover'])}}" alt=""/>
                                    <div class="flex-col">
                                        <p class="text">{{$group['name']}}</p>
                                        <p class="type">{{$group['type']}}</p>
                                    </div>
                                </a>
                                @if($currentUserProfile['user_id']==$group['owner'])
                                    <button group-id="{{$group['id']}}" class="manage-group">Manage</button>
                                    @else
                                    <button group-id="{{$group['id']}}" class="exit-group">Exit Group</button>
                                    @endif
                            </div>
                        @endforeach
                    @endif
                </div>
                <hr/>
                <div class="my-groups">
                    <h3>Pending Groups</h3>
                    @if(!empty($groupsInvitedTo))
                        @foreach($groupsInvitedTo as $group)
                            <div class="group-box flex-row">
                                <a href="{{route('group.route',$group['id'])}}" class="group-link flex-row">
                                    <img class="image" src="{{asset($group['path'].$group['cover'])}}" alt=""/>
                                    <div class="flex-col">
                                        <p class="text">{{$group['name']}}</p>
                                        <p class="type">{{$group['type']}}</p>
                                    </div>
                                </a>
                                <button group-id="{{$group['id']}}" class="accept-invite">Accept</button>
                                <button group-id="{{$group['id']}}" class="reject-invite">Decline</button>

                            </div>
                        @endforeach
                    @endif
                    @if(!empty($requestedGroups))
                        @foreach($requestedGroups as $group)
                            <div class="group-box flex-row">
                                <a href="{{route('group.route',$group['id'])}}" class="group-link flex-row">
                                    <img class="image" src="{{asset($group['path'].$group['cover'])}}" alt=""/>
                                    <div class="flex-col">
                                        <p class="text">{{$group['name']}}</p>
                                        <p class="type">{{$group['type']}}</p>
                                    </div>
                                </a>
                                <button group-id="{{$group['id']}}" class="cancel-request">Cancel Request</button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <hr/>
            </div>
            <div class="right-section col-lg-4 col-xl-3 d-none d-lg-block d-xl-block">
                <h3> Suggested Groups</h3>
                <div class="group-cards flex-col">

                @if(empty($suggestedGroups))
                        <h4> No Groups To suggest</h4>
                    @else

                    @foreach($suggestedGroups as $group)
                        <div class="group-card" group-id="{{$group['id']}}">
                            <div class="card">
                                <img src="{{asset($group['path'].$group['cover'])}}" class="card-img" alt="...">
                                <div class="card-body">
                                    <h4 class="card-title">{{$group['name']}}</h4>
                                    <h6 class="card-subtitle mb-2 text-muted">{{$group['type']}}</h6>
                                    <p class="card-text">{{$group['desc']}}</p>
                                    <div class="text-center">
                                        <button  class="btn m-2 join-group" group-id="{{$group['id']}}">join Group</button>
                                        <button class="btn m-2 about-group" group-id="{{$group['id']}}">About</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_links')
    <script src="{{asset('front/js')}}/groups.js"></script>
@endsection
