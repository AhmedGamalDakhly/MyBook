@extends('front.layout.layout_basic')
@section('css_links')
    <link rel="stylesheet" href="{{asset('front/css')}}/signup.css" />
@endsection
@section('content')
    <div class="content container-fluid row" >
        <div class="patron-section col-lg-6 flex-col align-self-center">
            <h1 class="facebook">facebook</h1>
            <p>Facebook helps you connect and share with the people in your life.</p>
        </div>
        <div class="signup-section  col-lg-6 flex-col justify-content-center align-items-center align-slef-start">
            <form class="signup-form flex-col" method="POST" action="{{route('signup.route')}}">
                @include('errors')
                @csrf
                <input class="text-field" type="text" placeholder="Profile Name" name="name" value=""/>
                <input class="text-field" type="text" placeholder="First Name" name="first_name" value=""/>
                <input class="text-field" type="text" placeholder="Last Name" name="last_name" value=""/>
                <div class="gender">
                    <label >Gender</label>
                    <select name="gender">
                        <option  >Male</option>
                        <option  >Female</option>
                    </select>
                </div>
                <div class="date_of_birth">
                    <label >Date of Birth :</label>
                    <select  name="day">
                        <option >1</option>
                        <option >2</option>
                        <option >3</option>
                        <option >4</option>
                        <option >5</option>
                        <option >6</option>
                        <option >7</option>
                        <option >8</option>
                        <option >9</option>
                        <option >10</option>
                        <option >11</option>
                        <option >12</option>
                        <option >13</option>
                        <option >14</option>
                        <option >15</option>
                        <option >16</option>
                        <option >17</option>
                        <option >18</option>
                        <option >19</option>
                        <option >20</option>
                        <option >21</option>
                        <option >22</option>
                        <option >23</option>
                        <option >24</option>
                        <option >25</option>
                        <option >26</option>
                        <option >27</option>
                        <option >28</option>
                        <option >29</option>
                        <option >30</option>
                        <option >31</option>
                    </select>
                    <select name="month" >
                        <option >January</option>
                        <option >Febraury</option>
                        <option >Mars</option>
                        <option >April</option>
                        <option >May</option>
                        <option >June</option>
                        <option >July</option>
                        <option >August</option>
                        <option >September</option>
                        <option >October</option>
                        <option >November</option>
                        <option >December</option>
                    </select>
                    <select name="year" >
                        <option >1990</option>
                        <option >1991</option>
                        <option >1992</option>
                        <option >1993</option>
                        <option >1994</option>
                        <option >1995</option>
                        <option >1996</option>
                        <option >1997</option>
                        <option >1998</option>
                        <option >1999</option>
                        <option >2000</option>
                        <option >2001</option>
                        <option >2002</option>
                        <option >2003</option>
                        <option >2004</option>
                        <option >2005</option>
                        <option >2006</option>
                        <option >2007</option>
                    </select>
                </div>
                <input class="text-field" type="text" placeholder="Email Address" name="email" value=""/>
                <input class="text-field" type="text" placeholder="Phone Number" name="phone" value=""/>
                <input class="text-field" type="password" placeholder="Password" name="password" />
                <input class="text-field" type="password" placeholder="Retype Password" name="password_confirmation"/>
                <button class="button signup-btn" type="submit"  name="signup">SignUp</button>
                <hr/>
                <p>already has an Accound ?<a class="login-link" href="{{route('loginForm.route')}}" type="submit"  >Login</a></p>
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
