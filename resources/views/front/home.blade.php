@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}{{$layout}}/home.css"  />
@endsection
@section('content')
	<div class="content">
		<div class="profile-page flex-row align-items-start">

			<div class="left-section col-3  d-none d-xl-block ">
				<div class="additional-options layout-left">
					<div class="link-wrapper">
						<a class="image_text-link" href="{{route('profile.route')}}">
							<img class="image" src="{{asset($currentUserProfile['path'].$currentUserProfile['image'])}}" alt=""/>
							<p class="text">{{$currentUserProfile['name']}}</p>
						</a>
					</div>
					<div class="link-wrapper">
						<a href="{{route('friends.route')}}" class="image_text-link">
							<i class="icon fas fa-user-friends"></i>
							<p class="text">Friends</p>
						</a>
					</div>
					<div class="link-wrapper">
						<a href="{{route('groups.route')}}" class="image_text-link">
							<i class="icon fas fa-users"></i>
							<p class="text">Groups</p>
						</a>
					</div>
					<div class="link-wrapper">
						<a class="image_text-link">
							<i class="icon fas fa-flag"></i>
							<p class="text">Pages</p>
						</a>
					</div>
					<div class="link-wrapper">
						<a class="image_text-link">
							<i class="icon fas fa-calendar-check"></i>
							<p class="text">Events</p>
						</a>
					</div>
					<div class="link-wrapper">
						<a class="image_text-link">
							<i class="icon fas fa-store"></i>
							<p class="text">Market</p>
						</a>
					</div>
					<div class="link-wrapper">
						<a class="image_text-link">
							<i class="icon fas fa-bookmark"></i>
							<p class="text">Saved</p>
						</a>
					</div>
					<div class="link-wrapper">
						<a class="image_text-link">
							<i class="icon fas fa-chevron-circle-down"></i>
							<p class="text">See more</p>
						</a>
					</div>
					<hr>
					<h4 class="section-title">Your Shortcuts</h4>
					<div class="link-wrapper" >
						<a class="image_text-link">
							<img class="image" src="https://i.imgur.com/ZTkt4I5.jpg" alt=""/>
							<p class="text">Egypt Germany School</p>
						</a>
					</div>
					<div class="link-wrapper" >
						<a class="image_text-link">
							<img class="image" src="https://i.imgur.com/ZTkt4I5.jpg" alt=""/>
							<p class="text">Egypt Tea Company</p>
						</a>
					</div>
				</div>
			</div>

			<div class="middle-section  col-lg-8 col-xl-6">
					<div id='homePage' class="home-page">
						<div class="stories-section flex-row justify-content-center">
							<a href="" class="story-box">
								<img class="story-image" src="{{asset($currentUserProfile['path'].$currentUserProfile['image'])}}" alt="">
								<div class="add-story position" >
									<i class="plus-icon position fas fa-plus-circle"></i>
									<p>Create a Story</p>
								</div>
							</a>
							<a href="" class="story-box ">
								<img class="profile-icon" src="{{asset($currentUserProfile['path'].$currentUserProfile['image'])}}"/>
								<img class="story-image" src="{{asset($currentUserProfile['path'].$currentUserProfile['image'])}}" alt="">
								<p class="profile-name" > Ahmed Gamal Dakhly</p>
							</a>
							<a href="" class="story-box ">
								<img class="profile-icon" src="https://i.imgur.com/ZTkt4I5.jpghttps://i.imgur.com/ZTkt4I5.jpg"/>
								<img class="story-image" src="https://www.w3schools.com/images/w3schools_green.jpg" alt="">
								<p class="profile-name" > Said Mansour</p>
							</a>
							<i class="more-btn position fas fa-arrow-right"></i>
						</div>
                        @include('front.post_form')
                        <br>
                        <div class="mayknow ">
							<h4>People you may know</h4>
							<br>
							<div class="cards-group flex-row justify-content-center">
                                @if(!empty($suggestedFriends))
                                    @foreach($suggestedFriends as $suggestedFriend)
                                        @break($loop->index==3)
                                        <div class="user-card flex-col" >
										<img class="image" src="{{asset($suggestedFriend['path'].$suggestedFriend['image'])}}" alt=""/>
										<div class="body" >
											<h4 class="name">{{$suggestedFriend['name']}}</h4>
											<div class="meta-data">
												<p>7 mutual friends</p>
											</div>
											<div class="actions">
												<button  friend-id="{{$suggestedFriend['user_id']}}"  class="add-btn add-friend">Add Freind</button>
											</div>
										</div>
								</div>
                                    @endforeach
                               @endif
							</div>
						</div>

					</div>
                @include('front.posts')
            </div>

			<div class="right-section col-lg-4 col-xl-3 d-none d-lg-block d-xl-block">
				<div class="contacts-groups layout-right">
					<div class="advertise-box">
						<h4 class="section-title">Sponsored</h4>
						<div class="advertise flex-row">
							<img src="https://i.imgur.com/ZTkt4I5.jpg"  alt=""/>
							<p>This content is delivered to you by Facebook , If you like please Rate us to show more. </p>
						</div>
					</div>
					<div class="contacts-box">
						<div class="text-icon-box flex-row align-items-center">
							<h4 class="text">Contacts</h4>
							<i class="icon fas fa-video circle-icon"></i>
							<i class="icon fas fas fa-search circle-icon"></i>
							<i class="icon fas fas fa-ellipsis-h circle-icon"></i>
						</div>
                        <hr>
                        @if(!empty($myFriends))
                            @foreach($myFriends as $friend)
                             <div class="link-wrapper" >
                                <a class="image_text-link" href="{{route('chat.route',$friend['user_id'])}}">
                                    <img class="image" src="{{asset($friend['path'].$friend['image'])}}" alt=""/>
                                    <p class="text">{{$friend['name']}}</p>
                                    @if(Cache::has('user-is-online-' .$friend['user_id']))
                                    <i class=" dot active-dot far fa-circle"></i>
                                    @else
                                        <i class=" dot  far fa-circle"></i>
                                    @endif
                                </a>
						    </div>
                            @endforeach
                        @endif
                        <hr>
                    @if(count($myFriends)<5)
                            <a class="more-friends" href="{{route('friends.route')}}" class="text">Add More Friends to Chat with</a>
                        @endif
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection
@section('js_links')
    <script src="{{asset('front/js')}}/like.js"></script>
    <script src="{{asset('front/js')}}/home.js"></script>
    <script src="{{asset('front/js')}}/post.js"></script>
    <script src="{{asset('front/js')}}/friendHandle.js"></script>
@endsection
