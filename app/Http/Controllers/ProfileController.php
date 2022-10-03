<?php

namespace App\Http\Controllers;

use App\Content;
use App\User;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     *  Get profile of a user
     * @param User $user current authenticated user
     * @param String $id of the uer to get his profile
     * @return \Illuminate\View\View
     */
    public function index(User $user ,$id=null){
        $userID=$user['id'];
        $ProfilePageData['pageType']='profile';
        $ProfilePageData['pageID']=$userID;
        if($id===null){
            $profile=Profile::where('user_id',$userID)->first();
        }else{
            $profile=Profile::where('user_id',$id)->first();
        }
        $ProfilePageData['profileLock']=false;
        $ProfilePageData['profile']=$profile;
        $ProfilePageData['posts']=$profile->posts;
        if(auth()->user()->cannot('view',$profile)){
            $ProfilePageData['profileLock']=true;
        }
        $ProfilePageData['pageType']='profile';
        $ProfilePageData['pageID']=$userID;
        return view('front.profile')->with($ProfilePageData);
    }

    /**
     *  Change  cover or image  of the Profile
     * @param Request $request http request
     * @param User $user current authenticated user
     * @param String $id of the uer to get his profile
     * @param String $type of image to change ( image - cover)
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeImg(Request $request,User $user,$id,$type){//back here
        $userID=$user['id'];
        $profile=$user->profile;
        $accessResponse = Gate::inspect('update',$profile);
        if($accessResponse->allowed()) {
            $validate=$request->validate([
                'image_file' => 'file'
            ]);
            if($request->hasFile('image_file')) {
                $data = $request->file('image_file');
                $data->store('');
                $img = Image::make($data);
                $imgName = $type . 'img' . rand(12345, 9999) . $userID . '.' . $data->getClientOriginalExtension();
                $profilePath = 'uploads/profiles/profile_id' . $userID . '/';
                $imgPath = $profilePath . $imgName;
                $img->save($imgPath);
                if ($type == 'cover') {
                    $profile ->update(['cover' => $imgName, 'path' => $profilePath]);
                } elseif ($type == 'profile') {
                    $profile->update(['image' => $imgName, 'path' => $profilePath]);
                }
                return response()->json(['check' => 'success', 'newImgSrc' => $imgPath, 'msg' => $accessResponse->message()]);
            }
        }
        return response()->json(['check' => 'failed', 'msg' => $accessResponse->message()]);
    }

    /**
     *  Show  Settings of the Profile
     * @param Request $request http request
     * @return \Illuminate\View\View
     */
    public  function showSettings(Request $request){
        return view('front.settings');
    }

    /**
     *  Change  Settings of the Profile
     * @param Request $request http request
     * @param User $user current authenticated user
     * @return \Illuminate\Http\RedirectResponse or logout the user
     */
    public  function changeSettings(Request $request,User $user)
    {
        $profile=$user->profile;
        $accessResponse = Gate::inspect('update',$profile);
        if($accessResponse->allowed()) {
            $profileData=$request->validate([
                        'name'=>'required|max:60',
                        'phone'=>'required|max:11',
                        'layout'=>'required|max:10',
                        'lock'=>'required|max:10',
                        'current_password' => 'required| min:4| max:7',
                        'password' => 'required| min:4| max:7 |confirmed',
                        'password_confirmation' => 'required| min:4|max:7'
                    ]);
            $settings['layout']='light';
            $settings['lock']='off';
            if( strtolower($profileData['layout'])=='dark'){
                $settings['layout']='dark';
            }
            if($profileData['lock']=="on"){
                $settings['lock']='on';
            }
            if(Hash::check($profileData['current_password'], $user['password'])){
                $profileData['settings']=json_encode($settings);
                        $user->update(['password'=>bcrypt($profileData['password'])]);
                     Profile::where('user_id',$user['id'])->update(['name'=>$profileData['name'],'phone'=>$profileData['phone'],'settings'=>$profileData['settings']]);
                        LoginController::logout($request,$user);
                    }
                return redirect()->back()->withErrors('current password is not correct');
            }
        LoginController::logout();
    }
}
