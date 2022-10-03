@extends('front.layout.layout_basic')
@section('css_links')
	<link rel="stylesheet" href="{{asset('front/css')}}/login.css" />
@endsection
@section('content')
	<div class="content conteiner row" >
			<div class="patron-section col-lg-6 flex-col">
				<h1 class="facebook">facebook</h1>
				<p>Facebook helps you connect and share with the people in your life.</p>
			</div>
			<div class="login-section col-lg-6 flex-col flex-center-perfect ">
                @include('errors')
				<form dusk='login-form' class="login-form flex-col flex-center-perfect align-self-center" method="POST" action="{{route('login.route')}}">
                    @csrf
					<input class="text-field" type="text" placeholder="Email address or Phone Number" name="email" value ="{{ old('email') }}"/>
					<input class="text-field" type="password" placeholder="Password" name="password" />
					<button class="button login-btn" type="submit" name="login">login</button>
					<a class="password-reset" href="">Forgotten password ? </a>
					<hr/>
                    <a href="{{route('signupForm.route')}}" class="button new-account-btn" type="submit" name="new_account"  value="">Create New Account</a>
				</form>
				<p class="business-page"><a href="">Create a Page</a> for a celebrity, brand or business.<p/>
		    </div>
	</div>
	<footer >
		<hr/>
		<ul class="translate-links">
			<li class="translate-link"><a href="">English</a></li>
			<li class="translate-link"><a href="">Spaniol</a></li>
			<li class="translate-link"><a href="">French</a></li>
			<li class="translate-link"><a href="">Arabic</a></li>
		</ul>
		<p class="copyright">@Ahmed Gamal Dakhly</p>
	</footer>
@endsection

