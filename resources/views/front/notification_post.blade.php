@extends('front.layout.layout')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}/home.css"  />
@endsection
@section('content')
	<div class="content">
		<div class="profile-page flex-row align-items-start">

			<div class="left-section col-3  d-none d-xl-block ">
				<div class="additional-options layout-left">
				</div>
			</div>

			<div class="middle-section  col-lg-8 col-xl-6">
					<div class="home-page">
					</div>
                @include('front.posts')
            </div>

			<div class="right-section col-lg-4 col-xl-3 d-none d-lg-block d-xl-block">
				<div class="contacts-groups layout-right">
				</div>
			</div>
		</div>
    </div>
@endsection
@section('js_links')
    <script src="{{asset('front/js')}}/like.js"></script>
    <script src="{{asset('front/js')}}/home.js"></script>
    <script src="{{asset('front/js')}}/post.js"></script>
@endsection
