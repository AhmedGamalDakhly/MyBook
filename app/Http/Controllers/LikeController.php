<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    /**
     *  Like or Unlike content (post - comment- reply )
     * @param  User  $user of the authenticated user
     *  @param  String  $contentID of the content to like
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(User $user,$contentID){//please add constraint to route paramaters
        $content=Content::where('id',$contentID)->first();
        $type=$content['type'];
        if($content) {
            $isLiked=$content->isLiked($user['id']);
            if($isLiked){
                $content->unLike($user);
                NotificationController::deleteNotification($user['id'],$contentID,'like-'.$type);
                return response()->json(['check'=> 'success','like_count'=>$content['like_count'], 'isLiked'=>false,'msg'=> 'unliked']);

            }else{
                $content->like($user['id']);
                NotificationController::addNotification($user->profile, $contentID,'posts','like-'.$type);
                return response()->json(['check'=> 'success','like_count'=>$content['like_count'], 'isLiked'=>true,'msg'=> 'liked']);
            }
        }
    }



}
