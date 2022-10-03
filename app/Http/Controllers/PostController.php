<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Image;

class PostController extends Controller
{
    /**
     *  make new post
     * @param  Request  $request http request
     *   @param  User  $user as authenticated user
     * @return \Illuminate\Http\RedirectResponse
     */
    public  function post(Request $request,User $user){
        $contentData=$request->validate([
            'text'=>'max:300',
            'page_type'=>'required',
            'page_id'=>'required',//defines the oner of the post page , group , or profile
        ]);
        $contentData['image']=null;
        if($request->hasFile('uploaded_file')) {
            $contentData['image'] = $request->file('uploaded_file');
        }
        $post=PostController::makeContent($user,$contentData,null,"post");
        NotificationController::addNotification($user->profile,$post['id'],'posts','post-create');
        return Redirect::back();
    }

    /**
     * Get Specific post
     *   @param  String  $postID of the post to get
     * @return \Illuminate\View\View
     */
    public  function getPost($postID){
        $data['posts']=array(Content::getParentPost($postID));
        return view('front.home2')->with($data);
    }
        //back here
    /**
     *  make new comment to a post
     * @param  Request  $request http request
     * @param  User  $user as authenticated user
     * @param  String  $postID of the post commented on
     * @return Redirect
     */
    public  function comment(Request $request,User $user,$postID){
        $contentData=$request->validate([
            'text'=>'max:300',
            'page_type'=>'required',
            'page_id'=>'required',//defines the oner of the post page , group , or profile
        ]);
        $contentData['parent_id']=$postID;
        $contentData['image']=null;
        if($request->hasFile('uploaded_file')) {
            $contentData['image'] = $request->file('uploaded_file');
        }
        $post=PostController::makeContent($user,$contentData,$postID,"comment");
        NotificationController::addNotification($user->profile,$post['id'],'posts','comment-create');
        return redirect()->back();
    }
    /**
     *  make new Reply to a comment
     * @param  Request  $request http request
     * @param  User  $user as authenticated user
     * @param  String  $commentID of the comment replyed  on
     * @return Redirect
     */
    public  function reply(Request $request,User $user,$commentID){

        $contentData=$request->validate([
            'text'=>'max:300',
            'page_type'=>'required',
            'page_id'=>'required',//defines the oner of the post page , group , or profile
        ]);

        $contentData['image']=null;
        $contentData['parent_id']=$commentID;
        if($request->hasFile('uploaded_file')) {
            $contentData['image'] = $request->file('uploaded_file');
        }
        $post=PostController::makeContent($user,$contentData,$commentID,"reply");
        NotificationController::addNotification($user->profile,$post['id'],'posts','reply-create');
        return redirect()->back();

    }

    /**
     *  Delete Content (post - comment - reply )
     * @param User $user as authenticated user
     * @param String $contentID of the content to delete
     * @return \Illuminate\Http\JsonResponse
     */
    public  function delete(User $user,$contentID)
    {   $userID=$user['id'];
        $content=Content::where('id',$contentID)->first();
        $authGateResponse = Gate::inspect('delete',$content);
        if($authGateResponse->allowed()){
            PostController::deleteContent($userID,$contentID);
            return response()->json(['check'=> 'success','redirect'=>route('home.route'),'msg'=> $authGateResponse->message()]);
        }
        return response()->json(['check'=> 'success','redirect'=>route('home.route'),'msg'=>  $authGateResponse->message()]);
    }

    /**
     *  Share a post
     * @param  Request  $request http request
     * @param User $user as authenticated user
     * @param String $postID of the post to share
     * @return \Illuminate\Routing\Redirector
     */
    public  function share(Request $request,User $user,$postID){
        $contentData=$request->validate([
            'text'=>'max:300',
        ]);
        $contentData['image']=null;
        if($request->hasFile('uploaded_file')) {
            $contentData['image'] = $request->file('uploaded_file');
        }
        $sharedPost=PostController::makeContent($user,$contentData,$postID,"shared");
        NotificationController::addNotification($user->profile,$sharedPost['id'],'posts','post-share');
        return redirect('/home');
    }

    /**
     *  Make content for (post - comment - reply)
     * @param  Request  $request http request
     * @param User $user as  user made the content
     * @param Array $contentData of the content to create
     * @param String $parentID of the content
     * @param String $type of the content
     * @return \Illuminate\Routing\Redirector
     */
    public static function makeContent($user,$contentData,$parentID,$type="post"){
        $userID=$user['id'];
        $contentData['id']=Str::random(8);
        $contentData['user_id']=$userID;
        $contentData['type']=$type;
        $contentData['parent_id']=$parentID;
        $contentData['text']=self::treatTaggedContent($userID,$contentData);
        $img=$contentData['image'];
        if($img){
            $madeImage=Image::make($img);
            $imgName=$type.'_img'.Str::random(5).rand(12345,99999).'.'.$img->getClientOriginalExtension();
            $profilePath=$user->profile['path'];
            $imagePath=$profilePath.$imgName;
            $madeImage->save($imagePath);
            $contentData['image']=$imagePath;
            //save image file and the url of the image
        }
        return Content::create($contentData);;
    }

    /**
     *  Delete Content (post - comment - reply )
     * @param User $user as authenticated user
     * @param String $contentID of the content to delete
     * @return boolean
     */
    public static  function deleteContent($userID,$contentID)
    {
        if(Content::where('id',$contentID)->first()){
            Content::where(function ($query) use ($contentID,$userID){
                $query->where('id',$contentID)
                    ->where('user_id',$userID);
            })->first()->delete();
            return true;
        };
        return false;
    }

    /**
     *  Get profiles that are tagged in text
     * @param String $text to be searched for tags
     * @return array
     */
    public static  function getTaggedProfiles($text) {
        $tags=array();
       preg_match_all("/(#\w+)/u", $text, $tags);
       $profileTags=Profile::getTags();      //
        $taggedProfiles=array();
       foreach ($profileTags as $profileTag){

           if(in_array($profileTag['tag'],$tags[0])){
               $taggedProfiles[]=$profileTag;
           }
       }
        return $taggedProfiles;
    }

    /**
     *  Check Tags in Text ,Get tagged profiles , Send Notifications to tagged users
     * @param String $userID that made that content
     * @param Content $content to be searched for tags
     * @return array
     */
    public static function treatTaggedContent($userID,$content){
        $followers=array();
        $taggedProfiles=self::getTaggedProfiles($content['text']);
        $newText=$content['text'];
        foreach ($taggedProfiles as $taggedProfile){
            $followers[]=$taggedProfile['user_id'];
            $replace='<a href='.route('profile.route',$taggedProfile['user_id']).' >'.$taggedProfile['tag'].'</a>';
            $newText=str_replace($taggedProfile['tag'],$replace,$content['text']);
        }
        if($taggedProfiles){
            NotificationController::Notify($userID,$content['id'],'posts','tag',$followers);
        }
        return $newText;
    }


    }


