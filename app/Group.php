<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\True_;

class Group extends Model
{
    protected $guarded=[''];
    protected $casts = [
        'id' => 'string'
    ];

    //relationships
    /**
     * Get owner of this group ( user created the group )
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(){
        return $this->belongsTo('App\User','id','owner');
    }
    /**
     * Get owner profile of this group ( profile of user created the group )
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ownerProfile(){
        return $this->belongsTo('App\Profile','user_id','owner');
    }
    /**
     * Get  IDs  of members sent join request to   this group
     * @return boolean
     */
    public function requests(){
        $groupRequests=unserialize($this['requests']);
        return $groupRequests;
    }

    /**
     * Get members IDs of  this group
     * @return boolean
     */
    public function membersIDs(){
        $groupMembers=unserialize($this['members']);
        return $groupMembers;
    }


    /**
     *  add new member to this group
     * @param  String  $userID  of the user to be added to the group
     * @return void
     */
    public function addMember($userID){
        $groupMembers=unserialize($this['members']);
        $membersCount= $this['members_count'];
        if(is_array($groupMembers)) {
            if (!in_array($userID, $groupMembers)) {
                $groupMembers[]=$userID;
                $membersCount++;
            }
        }
        else{
            $groupMembers[]=array($userID);
        }
        $groupUpdate['members']=serialize($groupMembers);
        $groupUpdate['members_count']=$membersCount;
        $this->update($groupUpdate);

    }

    /**
     *  remove member to this group
     * @param  String  $userID  of the user to be removed from the group
     * @return void
     */
    public function removeMember($userID){
        $groupMembers=unserialize($this['members']);
        $membersCount= $this['members_count'];
        if(is_array($groupMembers)) {
            if (in_array($userID, $groupMembers)) {
                $key = array_search($userID, $groupMembers);
                unset($groupMembers[$key]);
                $membersCount--;
            }
        }
        $groupUpdate['members_count']=$membersCount;
        $groupUpdate['members']=serialize($groupMembers);
        $this->update($groupUpdate);

    }

    /**
     *  Check if user is  member in this group
     * @param  String  $userID  of the user to be cheked against the group
     * @return boolean
     */
    public function isMember($userID){
        $groupMembers=unserialize($this['members']);
        if(is_array($groupMembers)) {
            if (in_array($userID, $groupMembers)) {
                return true;
            }
        }
        return false;
    }

    //handle group requests from members
    /**
     *  Add join request to this group
     * @param  String  $userID  of the user sent the request to join  the group
     * @return void
     */
    public function addRequest($userID){
        $groupRequests=unserialize($this['requests']);
        if(!is_array($groupRequests)){
            $groupRequests=array($userID);
        }
        else{
            $groupRequests[]=$userID;
        }

        $groupUpdate['requests']=serialize($groupRequests);
        $this->update($groupUpdate);
    }
    /**
     *  Remove/Reject/Delete join request in this group
     * @param  String  $userID  of the user sent the request to join  the group
     * @return void
     */
    public function removeRequest($userID){
        $groupRequests=unserialize($this['requests']);
        if(is_array($groupRequests)){
            if(in_array($userID,$groupRequests)){
                $key=array_search($userID,$groupRequests);
                unset($groupRequests[$key]);
            }
        }
        $groupUpdate['requests']=serialize($groupRequests);
        $this->update($groupUpdate);
    }

    /**
     *  Remove/Reject/Delete join request in this group
     * @param  String  $userID  of the user sent the request to join  the group
     * @return void
     */
    public function refuseRequest($userID){
        $this->removeRequest($userID);
    }

    /**
     *  Accept join request to this group
     * @param  String  $userID  of the user sent the request to join  the group
     * @return void
     */
    public function acceptRequest($userID){
        $this->removeRequest($userID);
        $this->addMember($userID);
    }

    /**
     *  Invite user  to this group
     * @param  String  $userID  of the user to invite to the group
     * @return void
     */
    public function addInvitation($userID){
        $groupInvitations=unserialize($this['invitations']);
        if(!is_array($groupInvitations)){
            $groupInvitations=array($userID);
        }
        else{
            $groupInvitations[]=$userID;
        }

        $groupUpdate['invitations']=serialize($groupInvitations);
        $this->update($groupUpdate);

    }

    /**
     *  Cancel user  Invitation to join group
     * @param  String  $userID  of the user invited to the group
     * @return void
     */
    public function removeInvitation($userID){
        $groupInvitations=unserialize($this['invitations']);
        if(is_array($groupInvitations)){
            if(in_array($userID,$groupInvitations)){
                $key=array_search($userID,$groupInvitations);
                unset($groupInvitations[$key]);
            }
        }
        $groupUpdate['invitations']=serialize($groupInvitations);
        $this->update($groupUpdate);
    }

    /**
     *  Refuse/Reject  Invitation to  group
     * @param  String  $userID  of the user Rejected the Invitation
     * @return void
     */
    public function refuseInvitation($userID){
        $this->removeInvitation($userID);
    }

    /**
     *  Accept  Invitation to join the group
     * @param  String  $userID  of the user Accepted the Invitation
     * @return void
     */
    public function acceptInvitation($userID){
        $this->removeInvitation($userID);
        $this->addMember($userID);
    }

    /**
     *  Check if user is already Invited to join the group
     * @param  String  $userID  of the user to check
     * @return boolean
     */
    public function isInvited($userID){
        $groupInvitations=unserialize($this['invitations']);
        if(is_array($groupInvitations)){
            if(in_array($userID,$groupInvitations)){
                return true;
            }
        }
        return false;
    }

    /**
     * Toggle (send - cancel) join  request to the group
     * @param  String  $userID  of the user sent the request
     * @return void
     */
    public function toggleRequest($userID){
        $groupRequests=unserialize($this['requests']);
        $state=true;
        if(is_array($groupRequests)){
            if(in_array($userID,$groupRequests)){
                $key=array_search($userID,$groupRequests);
                unset($groupRequests[$key]);
                $state=false;
            }else{
                $groupRequests[]=$userID;
            }
        }else{
            $groupRequests=array($userID);

        }
        $groupUpdate['requests']=serialize($groupRequests);
        $this->update($groupUpdate);
    }

    /**
     * Get groups that user Sent Join requests  (wants to join)
     * @param  String  $userID  of the user
     * @return array
     */
    public static function requestedToJoin($userID){
       $groups= Group::all();
        $requestedGroups=array();
       foreach ($groups as $group){
           $groupRequests=unserialize($group['requests']);
           if(is_array($groupRequests)){
               if(in_array($userID,$groupRequests)){
                   $requestedGroups[]=$group;
               }
           }
       }
       return $requestedGroups;
    }

    /**
     * Get groups that user has been Invited to join
     * @param  String  $userID  of the user
     * @return array
     */
    public static function groupsInvitedTo($userID){
        $groups= Group::all();
        $invitedToGroups=array();
        foreach ($groups as $group){
        $groupInvitations=unserialize($group['invitations']);
            if (is_array($groupInvitations)) {
                if (in_array($userID, $groupInvitations)) {
                    $invitedToGroups[] = $group;
                }
        }
        }
        return $invitedToGroups;
    }

    /**
     * Get groups that user has already joined (already member of them)
     * @param  String  $userID  of the user
     * @return array
     */
    public static function joinedGroups($userID){
        $groups= Group::all();
        $joinedGroups=array();

        foreach ($groups as $group){
            $groupMembers=unserialize($group['members']);
           //dd($groupMembers);

            if (is_array($groupMembers)) {
                    if (in_array($userID, $groupMembers)) {
                        $joinedGroups[] = $group;
                    }
            }
        }

        return $joinedGroups;
    }

    /**
     * Get groups suggested for  user to join (not member , not invited , no requests sent)
     * @param  String  $userID  of the user
     * @return array
     */
    public static function suggestedGroups($userID){
        $groups= Group::all();
        $suggestedGroups=array();
        foreach ($groups as $group){
            $groupMembers=unserialize($group['members']);
            $groupInvitations=unserialize($group['invitations']);
            $groupRequests=unserialize($group['requests']);
            $check=false;
            if (is_array($groupMembers)) {
                if (in_array($userID, $groupMembers)) {
                   continue;
                }
            }
            if (is_array($groupInvitations)) {
                if (in_array($userID, $groupInvitations)) {
                    continue;
                }
            }
            if (is_array($groupRequests)) {
                if (in_array($userID, $groupRequests)) {
                    continue;
                }
            }
            $suggestedGroups[]=$group;
        }
        return $suggestedGroups;
    }

}
