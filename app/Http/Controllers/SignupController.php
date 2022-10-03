<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SignupController extends Controller
{
    /**
     *  show SignUp form to make new user
     * @return \Illuminate\View\View
     */
    public  function index(){
        return view('front.signup');
    }

    /**
     *  Get SignUp form to make new user
     * @param  Request  $request http request
     * @return \Illuminate\Http\RedirectResponse
     */
    public  function signup(Request $request){
        $profileData=$request->validate([
            'name'=>'required|max:60',
            'first_name'=>'required|max:30',
            'last_name'=>'required|max:30',
            'gender'=>'required|max:10',
            'phone'=>'required|max:11|unique:profiles',

        ]);
        $userData=$request->validate([
            'email'=>'required|email|unique:users',
            'password' => 'required| min:4| max:7 |confirmed',
            'password_confirmation' => 'required| min:4|max:7'
        ]);
        $userID=Str::random(9);
        $user=User::create([
            'id'=>$userID,
            'email'=>$userData['email'],
            'password'=>bcrypt($userData['password']),
        ]);
        $profileData['user_id']=$userID;
        self::makeProfile($profileData);
        return redirect()->route('loginForm.route');
    }

    /**
     *  Make new profile
     * @param  Array  $profileData used to create profile
     * @return Profile
     */
    public static function makeProfile($profileData){
        $profile['user_id']=$profileData['user_id'];
        $profile['name']=$profileData['name'];
        $profile['first_name']=$profileData['first_name'];
        $profile['last_name']=$profileData['last_name'];
        $profile['gender']=$profileData['gender'];
        $profile['phone']=$profileData['phone'];
        $defaultProfilePath='uploads/profiles/default/';
        $profilePath='uploads/profiles/profile_id'.$profileData['user_id'];
        $profile['path']=$defaultProfilePath;
        $profile['tag']='#'.strtolower($profileData['name']).Str::random(4);
        $profile['date_of_birth']= date("Y/m/d");
        $profile['cover']='cover.jpg';
        $profile['image']='default.png';
        $profile['about']='';
        $settings=['layout'=>'light','lock'=>'off'];
        $profile['settings']=json_encode($settings);
        $profile['followings']=[$profileData['user_id']=>'profile'];
        $path = public_path($profilePath);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        return Profile::create($profile);
    }
}
