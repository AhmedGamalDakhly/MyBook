@extends('front.layout.layout_basic')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}/members.css"  />
@endsection
@section('content')
		<div class="main-section friends">
			<div class="search-results ">
					<div class="logo-search flex-row flex-center">
						<a class="logo-link"><i class=" fas fa-user-friends fa-3x"></i></a>
						<div class="search-box content-center">
							<i class="search-icon fas fa-search "></i>
							<input class="text-field" type="text" placeholder="Search Members" name="" />
						</div>
					</div>
					<div class="cards-group flex-row">

					</div>
			</div>
			<div class="my-friends ">
					<h4 class="head">Group Members</h4>
					<div class="cards-group flex-row"  group-id="{{$pageID}}">
                        @if($groupMembers != null)
                            @foreach($groupMembers as $member)
                                <div class="card-wrapper">
                                    <a href="{{route('profile.route',$member['user_id'])}}" class="image_text-link">
                                        <img class="image" src="{{asset($member['path'].$member['image'])}}" alt=""/>
                                        <p class="text">{{$member['name']}}</p>
                                    </a>
                                    @if($member['user_id']==$group['owner'])
                                        <h5 class="text-center">admin</h5>
                                    @else
                                        <div class="actions">
                                            <button group-id="{{$pageID}}" login-id="{{$member['user_id']}}" class="delete-btn remove-member" >Remove</button>
                                        </div>
                                     @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
            </div>
            <div class="my-friends ">
                <h4 class="head">Join Requests</h4>
                <div class="cards-group flex-row"  group-id="{{$pageID}}">
                    @isset($groupRequests)
                        @foreach($groupRequests as $member)
                            <div class="card-wrapper">
                                <a href="{{route('profile.route',$member['user_id'])}}" class="image_text-link">
                                    <img class="image" src="{{$member['path'].$member['image']}}" alt=""/>
                                    <p class="text">{{$member['name']}}</p>
                                </a>
                                <div class="actions">
                                    <button group-id="{{$pageID}}"  login-id="{{$member['user_id']}}" class="delete-btn approve-request" name="removeFriend">Approve</button>
                                    <button group-id="{{$pageID}}" login-id="{{$member['user_id']}}" class="delete-btn reject-request" name="removeFriend">Reject</button>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
            <div class="my-friends ">
                <h4 class="head">Add Members</h4>
                <div class="logo-search flex-row flex-center">
                    <a class="logo-link"><i class=" fas fa-user-friends fa-3x"></i></a>
                    <div class="search-box content-center">
                        <i class="search-icon fas fa-search "></i>
                        <input class="text-field" type="text" placeholder="Search Members" name="" />
                    </div>
                </div>
                <div class="cards-group flex-row">
                    @if($suggestedMembers != null)
                        @foreach($suggestedMembers as $member)
                            <div class="card-wrapper" group-id="{{$pageID}}">
                                <a href="{{route('profile.route',$member['user_id'])}}" class="image_text-link">
                                    <img class="image" src="{{$member['path'].$member['image']}}" alt=""/>
                                    <p class="text">{{$member['name']}}</p>
                                </a>
                                <div class="actions">
                                    @if($group->isInvited($member['user_id']))
                                        <button group-id="{{$pageID}}" login-id="{{$member['user_id']}}" class="add-btn invite-member">Invite Sent</button>
                                    @else
                                        <button group-id="{{$pageID}}" login-id="{{$member['user_id']}}" class="add-btn invite-member">Invite</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
@endsection
@section('js_links')
        <script src="{{asset('front/js')}}/groups.js"></script>
 @endsection

