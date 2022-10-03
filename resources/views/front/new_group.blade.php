@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}/new_group.css"  />
@endsection
@section('content')
	<div class="content groups-page container-fluid">
        <div class="row">
            <div class="left-section col-3  d-none d-xl-block ">
                <div class="additional-options">
                    <h1>Create Group</h1>
                        <div href="{{route('profile.route')}}" class="image_text-link">
                            <img class="image" src="{{asset($currentUserProfile['path'].$currentUserProfile['image'])}}" alt=""/>
                            <p class="text">{{$currentUserProfile['name']}}</p>
                        </div>
                    @include('errors')
                    <form class="create-group" action="{{route("groups.create.route")}}" method="POST">
                        @csrf
                        <input class="text-field" type="text" placeholder="Give a Group Name" name="name" />
                        <input class="text-field" type="text" placeholder="Give a Description" name="desc" />
                        <div class="group-privacy">
                            <label >Group Privacy</label>
                            <select name="type">
                                <option  >Public</option>
                                <option  >Privacy</option>
                            </select>
                        </div>
                        <input class="text-field" type="text" placeholder="Invite Friends" name="friends" />
                        <input class="create-btn" type="submit" name="create_group" value="Create Group"/>
                    </form>
                    <hr>
                </div>
            </div>
            <div class="main-section  col-lg-6 col-xl-6">
                <div class="group-preview">
                        <div class="flex-col ">
                            <img class="group-cover" src="https://i.imgur.com/ZTkt4I5.jpg" alt="">
                            <h1>Group Name</h1>
                            <h2>Group Privacy . <span>1 Member</span></h2>
                            <hr/>
                        </div>
                </div>
            </div>
            <div class="right-section col-lg-4 col-xl-3 d-none d-lg-block d-xl-block">
                <h3> My Groups</h3>
                <div class="group-cards flex-col">
                    <div class="group-card">
                        <div class="card">
                            <img src="https://i.imgur.com/ZTkt4I5.jpg" class="card-img" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Al-Ahly Today</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Group Description</h6>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="btn mr-2"><i class="fas fa-link"></i> Visit Group</a>
                                <a href="#" class="btn"><i class="fab fa-github"></i> Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_links')
    <script src="{{asset('front/js')}}/new_group.js"></script>
@endsection
