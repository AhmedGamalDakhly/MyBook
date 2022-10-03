@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}/group_page.css"  />
    <link rel="stylesheet" href="{{asset('front/css')}}/modal.css"  />
@endsection
@section('content')
    <div id="myModal" class="modal-wrapper fluid-container">
	    <div  class="my-modal row">
		<!-- Modal content -->
		<div class="modal-content col-10 col-sm-8">
			<span class="close-modal">&times;</span>
			<h2 id="modal-header"></h2>
			<img class="photo" id="modalPhoto" src=""/>
			<form  id="applyForm" class="file-upload-wrapper" groupID="{{$group['id']}}">
				<input class="upload-btn"  type="file"  id="uploadBtn" name="imageFile"/>
				<label class="upload-label"  for="uploadBtn" >
					<i class="label-icon fas fa-camera"></i>
				</label>
				<button type="submit" class="apply-btn" id="applyBtn" >APPLY</button>
			</form>
		</div>
	</div>
    </div>
	<div class="group-header">
		<div class="cover-setcion container">
			<img class="cover-photo" id="coverImg" src="{{asset($group['path'].$group['cover'])}}" alt="" />
            @can('update',$group)
            <button id="modalBtn-cover" data="cover" class="image-btn edit-btn btn-position">
				<i class="fas fa-camera"></i>
				<span class="d-none d-md-inline-block ">Edit Cover Photo</span>
			</button>
            @endcan
		</div>
		<div class="profile-info container ">

            <h1 class="group-name">{{$group['name']}}</h1>
            <h1 class="group-info">{{$group['type']}} <span> . {{$group['members_count']}} member</span></h1>
            <div class="options col-lg-4">
                <button class="add_story-btn"><i class="fas fa-plus-circle"></i> Invite</button>
                <button class="leave-group"><i class="fas fa-pen"></i>Leave Group</button>
            </div>


			<hr>
			<div class="profile-tabs row">
				<button href="" class="tab  about-tab">About</button>
				<button href="" class="tab  mambers-tab">Members</button>
				<a href="" class="tab  ">Photos</a>
				<a class="tab  ml-auto order-md-last  fas fa-ellipsis-h "></a>
				<a href="" class="tab  ">Events</a>
				<a href="" class="tab  ">Files</a>
				<a href="" class="tab  ">More <i class="fas fa-caret-down"></i></a>
			</div>
		</div>
	</div>
	<div class="content container">
        <iframe class="tab-frame" src="{{route('group.members.route',$pageID)}}">
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
            <div class="main-section  col-lg-8 col-xl-7">
                <div class="home-page ">
                    @include('front.post_form')
                    @include('front.posts')
                </div>
            </div>
        </iframe>
    </div>
@endsection
@section('js_links')
    <script src="{{asset('front/js')}}/group_page.js"></script>
    <script src="{{asset('front/js')}}/groups.js"></script>
@endsection
