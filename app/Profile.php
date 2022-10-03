<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $guarded=[];

    protected $primaryKey = 'user_id';

    protected $casts = [
        'user_id' => 'string' ,
        'followings' => 'array' ,
        '$settings' => 'array' ,
    ];

    /**
     *  Get user of this profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /**
     *  Get posts of this profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(){
        return $this->hasMany('App\Content','user_id','user_id')
            ->where('type','=','post')
            ->orderBy('created_at','DESC');;
    }

    /**
     * Get the followers of this profile (users who follow this profile and cares about it)
     * @return array of followers ids
     */
    public function followers(){
        return unserialize($this['followers']);
    }
    /**
     * Get the followings of this profile (users, groups who I follow and cares about them)
     * @return array of followers ids
     */
    public function followings(){
        return $this['followings'];
    }

    /**
     *  add something (profile,group,post)  to follow
     *@param String $id of the thing to follow
     * @param String $type of the thing to follow (profile,group,post)
     * @return void
     */
    public function follow($id,$type){
        $followings=$this['followings'];
        if(!isset($followings[$id])){
            $followings[$id]=$type;
        }
        $this->update(['followings' => $followings]);
    }

    /**
     *  stop following  something (profile,group,post)
     *@param String $id of the thing to unfollow
     * @param String $type of the thing to not follow (profile,group,post)
     * @return void
     */
    public function unFollow($id,$type){
        $followings=$this['followings'];
        if(isset($followings[$id])){
            if($followings[$id]==$type){
                unset($followings[$id]);
                $this->update(['followings' => $followings]);
            }
        }
    }

    /**
     *  Set profile to follow another profile
     *@param $userID of the profile or user to follow
     * @return void
     */
    public  function followProfile($friendID){
        $friendProfile=Profile::where('user_id',$friendID)->first();
        $this->follow($friendID,'profile');
        $friendProfile->addFollower($this['user_id']);
    }

    /**
     *  Set profile to unfollow another profile
     *@param $userID of the profile or user to unfollow
     * @return void
     */
    public  function unfollowProfile($friendID){
        $friendProfile=Profile::where('user_id',$friendID)->first();
        $this->unFollow($friendID,'profile');
        $friendProfile->removeFollower($this['user_id']);
    }

    /**
     *  Add follower to my profile
     *@param $userID of the profile or user wants to follow me
     * @return void
     */
    public function addFollower($userID){
        $followers=unserialize($this['followers']);
        if(is_array($followers)){
            if (!in_array($userID, $followers)) {
                $followers[]=$userID;
            }
        }
        $profileUpdate['followers']=serialize($followers);
        $this->update($profileUpdate);

    }
    /**
     *  Remove follower from my profile
     *@param $userID of the profile or user wants to unfollow me
     * @return void
     */
    public function removeFollower($userID){
        $followers=unserialize($this['followers']);
        if(is_array($followers)){
            if (in_array($userID, $followers)) {
                $key = array_search($userID, $followers);
                unset($followers[$key]);
            }
        }
        $profileUpdate['followers']=serialize($followers);
        $this->update($profileUpdate);

    }


    /**
     *  Change Layout mode of  this profile
     *@param String $layoutMode the profile or user wants to use (dark - light)
     * @return void
     */
    public  function changeLayout($layoutMode){
        $settings=json_decode($this['settings'],true);
        $settings['layout']=$layoutMode;
        $this->update(['settings',json_encode($settings)]);
    }

    /**
     *  Change Lock mode of  this profile
     *@param String $mode the profile or user wants to lock (on - off)
     * @return void
     */
    public  function lockProfile($mode='off'){
        $settings=json_decode($this['settings'],true);
        $settings['lock']=$mode;
        $this->update(['settings',json_encode($settings)]);
    }

    /**
     *  Get current settings of this profile
     * @return array
     */
    public  function settings(){
        $settings=json_decode($this['settings'],true);
        return $settings;
    }

    /**
     *  Get Lock mode of  this profile
     * @return String (on - off )
     */
    public  function lockState(){
        $settings=json_decode($this['settings'],true);
        return $settings['lock'];
    }
    /**
     *  Get Layout mode of  this profile
     * @return String (dark - light )
     */
    public  function layoutMode(){
        $settings=json_decode($this['settings'],true);
        return $settings['layout'];
    }

    /**
     *  Change settings of this profile
     *@param String $layoutMode profile layout mode (dark -light )
     *@param String $lockMode  profile  lock (on - off)
     * @return void
     */
    public  function updateSettings($layoutMode,$lockMode){
        $settings=json_decode($this['settings'],true);
        $settings['layout']=$layoutMode;
        $settings['lock']=$lockMode;
        $this->update(['settings',json_encode($settings)]);
    }

    /**
     *  Get all  tags for all profiles
     * @return \Illuminate\Database\Eloquent\Collection of tags
     */
    public static function getTags(){
        return Profile::select('user_id','tag')->get();
    }
}
