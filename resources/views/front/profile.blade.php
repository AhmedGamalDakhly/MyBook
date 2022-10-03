@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}{{$layout}}/profile.css"  />
    <link rel="stylesheet" href="{{asset('front/css')}}{{$layout}}/modal.css"  />
@endsection
@section('content')
    @if($currentUserProfile['user_id']===$profile['user_id'])
        <div id="myModal" class="modal-wrapper fluid-container">
	    <div  class="my-modal row">
		<!-- Modal content -->
		<div class="modal-content col-10 col-sm-8">
			<span class="close-modal">&times;</span>
			<h2 id="modal-header"></h2>
			<img class="photo" id="modalPhoto" src="{{asset($profile['path'].$profile['image'])}}"/>
			<form  id="applyForm" class="file-upload-wrapper" profileID="{{$profile['user_id']}}">
				<input class="upload-btn"  type="file"  id="uploadBtn" name="image_file"/>
				<label class="upload-label"  for="uploadBtn" >
					<i class="label-icon fas fa-camera"></i>
				</label>
				<button type="submit" class="apply-btn" id="applyBtn" >APPLY</button>
			</form>
		</div>
	</div>
    </div>
    @endif

	<div class="profile-header">
		<div class="cover-setcion container">
			<img  id="coverImg" src="{{asset($profile['path'].$profile['cover'])}}" alt="" />
            @if($profileLock)
                <div class="profile-lock position">
                    <i class=" fas fa-lock"></i>
                </div>
            @endif
            @if($currentUserProfile['user_id']===$profile['user_id'])
            <button id="modalBtn-cover" data="cover" class="image-btn edit-btn position">
				<i class="fas fa-camera"></i>
				<span class="d-none d-md-inline-block ">Edit Cover Photo</span>
            </button>
            @endif
        </div>
		<div class="profile-info container ">
			<div class="wrapper  row ">
				<div class="photo col-md-3 content-center">
					<img id="profImg" class="profile-image" src="{{asset($profile['path'].$profile['image'])}}" alt=""/>

                    @if($currentUserProfile['user_id']===$profile['user_id'])
                    <button id="modalBtn-profile" data="profile" class="edit-btn profile-img-btn">
						<i class="fas fa-camera"></i>
					</button>
                    @endif

                </div>
				<div class="middle-section col-lg-6 content-center ">
                    <h1 style="font-weight: bold;font-size:60px;">{{$profile['first_name'].' '.$profile['last_name']}}</h1>
					<p>78 Freinds</p>
					<div class="icon-links">
						<img class="icon circle-icon" src="" alt=""/>
						<img class="icon circle-icon" src="" alt=""/>
						<img class="icon circle-icon" src="" alt=""/>
						<img class="icon circle-icon" src="" alt=""/>
					</div>
				</div>
				<div class="profile-options content-center col-lg-3">
                    @if($currentUserProfile['user_id']===$profile['user_id'])
                    <button class="add-story-btn"><i class="fas fa-plus-circle"></i> Add To Story</button>
					<button class="edit-btn"><i class="fas fa-pen"></i> Edit Profile</button>
                     @else
                        <button class="edit-btn">Follow Profile</button>
                    @endif
                </div>
			</div>
			<hr>
			<div class="profile-tabs row align-items-center">
				<a href="" class="tab  ">Posts</a>
				<a href="" class="tab  ">About</a>
				<a href="" class="tab  ">Friends</a>
				<a href="" class="tab  ">Photos</a>
				<a class="tab  ml-auto order-md-last  fas fa-ellipsis-h "></a>
				<a href="" class="tab  ">Story Archive</a>
				<a href="" class="tab  ">Videos</a>
				<a href="" class="tab  ">More <i class="fas fa-caret-down"></i></a>
			</div>
		</div>
	</div>

	<div class="profile-body container">
		<div class="row">
			<div class="left-section flex-col col-lg-4 col-xl-5">
				<div class="intro  ">
					<h1>Intro</h1>
					<p>
						to give an element a specific width.
						Whenever column classes are used as
					</p>
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
         @unless($profileLock)
            <div class="main-section  col-lg-8 col-xl-7">
                    @include('front.post_form')
                    @include('front.posts')
            </div>
        @endcan
         </div>
    </div>
@endsection
@section('js_links')
    <script src="{{asset('front/js')}}/like.js"></script>
    <script src="{{asset('front/js')}}/profile.js"></script>
    <script src="{{asset('front/js')}}/post.js"></script>
@endsection
