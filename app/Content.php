<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Ramsey\Collection\Collection;

class Content extends Model
{

    protected $guarded=[];
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $casts = [
        'id' => 'string',
        'likers' => 'array' ,

    ];

    /**
     * Get  user made this content (post-comment-reply)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * Get  profile of user made this content (post-comment-reply)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile(){
        return $this->belongsTo('App\Profile','user_id','user_id');
    }

    /**
     * Get  comments for specific post
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(){
        return $this->hasMany('App\Content','parent_id','id')
            ->where('type','=','comment')
            ->orderBy('created_at','DESC');
    }
    /**
     * Get  shared posts for this post
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shares(){
        return $this->hasMany('App\Content','parent_id','id')
            ->where('type','=','share');
    }
    /**
     * Get  replys for specific post
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replys(){
        return $this->hasMany('App\Content','parent_id','id')
            ->where('type','=','reply')
            ->orderBy('created_at','ASC');
    }

    /**
     * Get  shared  post
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sharedPost(){
        return $this->hasOne('App\Content','id','parent_id');
    }

    /**
     *  Get parent post of this content that maybe (comment - reply - post )
     *
     * @param  String  $contentID  of the content the notification made on
     * @return   Post
     */
    public static function getParentPost($contentID){
        $post=Content::where('id',$contentID)->get()->first();
        while(true){
            if($post['type']=='post'){
                break;
            }
            $post=Content::where('id',$post['parent_id'])->first();
        }
        return $post;
    }

    /**
     *  Set like for user in this post
     *
     * @param  String  $userID  of the user liked the post
     * @return   void
     */
    public  function like($userID){//please add constraint to route paramaters
        $like_count=$this['like_count'];
        $likersArr=unserialize($this['likers']);
            if(is_array($likersArr)){
                $likersArr[]=$userID;
            }else{
                $likersArr=array($userID);
            }
            $like_count++;
            $contentUpdate['like_count']= $like_count;
            $contentUpdate['likers']= serialize($likersArr);
            $this->update($contentUpdate);
    }

    /**
     *  Check if user liked this post
     *
     * @param  String  $userID  of the user to check if they liked the post
     * @return   boolean
     */
    public function isLiked($userID){
        $likersArr=unserialize($this['likers']);
            if(is_array($likersArr)){
                if(in_array($userID,$likersArr)){
                    return true;
                }
            }
            return false;
    }
    public function getTimeLinePosts($userID){

    }

    /**
     *  unSet like for user in this post
     *
     * @param  String  $userID  of the user liked the post
     * @return   void
     */
    public  function unLike($userID){//please add constraint to route paramaters
        $like_count=$this['like_count'];
        $likersArr=unserialize($this['likers']);
        if(is_array($likersArr)){
            $key = array_search($userID, $likersArr);
            unset($likersArr[$key]);
            $like_count--;
            $contentUpdate['like_count'] = $like_count;
            $contentUpdate['likers'] = serialize($likersArr);
            $this->update($contentUpdate);
        }

    }

    /**
     *  Set or Unset (toggle) like for user in this post
     *
     * @param  String  $userID  of the user liked the post
     * @return   boolean
     */
    public  function toggleLike($userID){//please add constraint to route paramaters
        if($this->isLiked($userID)) {
           $this->unLike($userID);
            return false;
        }else{
            $this->like($userID);
            return true;
        }
    }

    /**
     * Get Available Pots of Group  (Group timeline)
     * @param  String  $groupID  of the group to get posts
     * @return  \Illuminate\Database\Eloquent\Collection of Contents
     */

    public static function groupPosts($groupID,$limit){
        $posts=Content::where(function ($query) use ($groupID){
            $query->where('page_type','group')
                ->where('page_id',$groupID);
        })->take($limit)->orderBy('updated_at','DESC')->get();
        return $posts;
    }

    /**
     * Get Available Pots of Group  (Group timeline)
     * @param  String  $groupID  of the group to get posts
     * @return  \Illuminate\Database\Eloquent\Collection of Contents
     */


}
