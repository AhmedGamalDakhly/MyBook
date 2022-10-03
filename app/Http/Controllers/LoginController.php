<?php

namespace App\Http\Controllers;

use App\Content;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     *  View Login Form in order to login
     */
    public function index(){

        return view('front.login');
    }
    /**
     *  check credentials for login
     * @param  Request  $request of the user caused the notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request){
        $credentials=$request->validate([
            'email'=>['required','email','exists:users,email'],
            'password'=>['required','min:5'],
        ]);

    if(auth()->guard('login')->attempt($credentials)){
        $request->session()->regenerate();
        return redirect()->intended('/');
    }else{
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();}

    }

    /**
     *  check user out (log out ) and delete the session data
     * @param  Request  $request http request
     *  @param  User  $user current authenticated user
     * @return View  login view (login page )
     */
    public static function logout(Request $request,User $user){
        Cache::forget('user-is-online-'.$user['id'] );
        auth()->guard('login')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return view('front.login');
    }
}
