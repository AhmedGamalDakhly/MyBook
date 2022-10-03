@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}{{$layout}}/friends.css"  />
@endsection
@section('content')
		<div class="main-section container friends align-slef-start">
            <h1>Friends</h1>
			<div class="search-results ">
					<div class="logo-search flex-row flex-center">
						<a class="logo-link" href="home.php"><i class=" fas fa-user-friends fa-3x"></i></a>
						<div class="search-box content-center">
							<i class="search-icon fas fa-search "></i>
							<input class="text-field" type="text" placeholder="Search Friends" name="" />
						</div>
					</div>

            </div>
            <div class="my-friends  friend-requests">
                <h4 class="head">Pending Requests</h4>
                <div class="cards-group  flex-row">
                    @if($sentRequests->isEmpty() && $receivedRequests->isEmpty())
                        <h4>
                            No Pending Requests
                        </h4>
                    @else
                        @foreach($sentRequests as $friend)
                            <div class="card-wrapper">
                                <a href="{{route('profile.route',$friend['user_id'])}}" class="image_text-link">
                                    <img class="image" src="{{$friend['path'].$friend['image']}}" alt=""/>
                                    <p class="text">{{$friend['first_name'].' '.$friend['last_name']}}</p>
                                </a>
                                <div class="actions">
                                    <button friend-id="{{$friend['user_id']}}"  class="add-btn reject-request" name="addFriend">Cancel Request</button>
                                </div>
                            </div>
                        @endforeach
                        @foreach($receivedRequests as $friend)
                                <div class="card-wrapper">
                                    <a href="{{route('profile.route',$friend['user_id'])}}" class="image_text-link">
                                        <img class="image" src="{{$friend['path'].$friend['image']}}" alt=""/>
                                        <p class="text">{{$friend['first_name'].' '.$friend['last_name']}}</p>
                                    </a>
                                    <div class="actions">
                                        <button friend-id="{{$friend['user_id']}}"  class="add-btn approve-request" name="addFriend">Approve Request</button>
                                        <button friend-id="{{$friend['user_id']}}" class="delete-btn reject-request" name="removeFriend">Reject Request</button>
                                    </div>
                                </div>
                            @endforeach
                    @endif
                </div>
            </div>
            <div class="my-friends suggested-friends">
                <h4 class="head">You May Know </h4>
                <div class="cards-group flex-row">
                    @if(!empty($suggestedFriends))
                        @foreach($suggestedFriends as $friend)
                            <div class="card-wrapper">
                                <a href="{{route('profile.route',$friend['user_id'])}}" class="image_text-link">
                                    <img class="image" src="{{$friend['path'].$friend['image']}}" alt=""/>
                                    <p class="text">{{$friend['first_name'].' '.$friend['last_name']}}</p>
                                </a>
                                <div class="actions">
                                    <button friend-id="{{$friend['user_id']}}"  class="add-btn add-friend" name="addFriend">Add Freind</button>
                                    <button friend-id="{{$friend['user_id']}}" class="delete-btn remove-friend" name="removeFriend">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
			<div class="my-friends current-friends">
					<h4 class="head">My Friends </h4>
					<div class="cards-group flex-row">
                            @if($myFriends->isNotEmpty())
                                @foreach($myFriends as $key =>  $friendProf)
                                    <div class="card-wrapper">
                                        <a class="image_text-link" href="{{route('profile.route',$friendProf)}}">
                                            <img class="image" src="{{$friendProf['path'].$friendProf['image']}}" alt=""/>
                                            <p class="text">{{$friendProf['first_name'].' '.$friendProf['last_name']}}</p>
                                        </a>
                                        <div class="actions">
                                            <button friend-id="{{$friendProf['user_id']}}" class="unfriend-btn remove-friend">Unfriend</button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                            <h4>
                                No Friends Yet
                            </h4>
                            @endif

                    </div>

            </div>
        </div>
@endsection
@section('js_links')
        <script src="{{asset('front/js')}}/friendHandle.js"></script>
 @endsection

