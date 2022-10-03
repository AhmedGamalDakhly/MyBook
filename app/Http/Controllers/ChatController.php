<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\FriendRequest;
use App\Chat;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class ChatController extends Controller
{
    /**
     *  Show Messanger (Chat app) for current user
     * @return View
     */
    public function index()
    {
        return view('front.messanger');
    }


    /**
     *  Send New Message (sender = current user )
     * @param  Request  http request
     * @param  User  $user  current authenticated user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request, User $user){
        if ($request->hasFile('msg_file')){
            $msgData=$request->validate([
                'text'=>'max:300',
                'receiver'=>'exists:users,id',
                'msg_file' => 'file',
            ]);
        }
        else{
            $msgData=$request->validate([
                'text'=>'required|max:300',
                'receiver'=>'exists:users,id'
            ]);
        }
        $userID=$user['id'];
        $message=self::makeMessage($msgData, $userID);
        NewChatMessage::dispatch($message,$msgData['text']);
        return redirect()->back();
    }

    /**
     * Show Messanger (Chat Messages) for current user with another user
     * @param  User  $user  current authenticated user
     *@param  String  $friendID for the other user
     * @return View
     */
    public  function getChat(User $user, $friendID=null){
        $userID=$user['id'];
        $data['hasFriend']=true;
        if($friendID===null){
            $friends=FriendRequest::friendsIDs($userID);
            if($friends->isNotEmpty()){
                $friendID=$friends[0];
            }
            else{
                $data['hasFriend']=false;
                return view('front.messanger')->with($data);
            }
        }
        $data['messages']=Chat::messages($userID,$friendID);
        $data['userProfile']=Profile::where('user_id',$friendID)->first();
        Chat::setSeen($userID,$friendID);
        return view('front.messanger')->with($data);
    }


    /**
     * Make new  Message between sender user and another user
     * @param Array $msg Message to create
     * @param String $senderID for the sender
     * @return Chat
     */
    protected static function makeMessage($msg, $senderID){
        $receiverID=$msg['receiver'];
        if($senderID != $receiverID) {
            $chat['id'] = $senderID . "_" . $receiverID;
            $chat['message_id'] = Str::random(10);
            $chat['sender'] = $senderID;
            $chat['receiver'] = $receiverID;
            $chat['status'] = 'unseen';
            if (isset($msg['msg_file'])) {
                $msgImg =$msg['msg_file'];
                $madeImage = Image::make($msgImg);
                $chatPath = 'uploads/chats/' . $chat['id'] . '/';
                $imgName = 'msg_img' . Str::random(5) . rand(12345, 99999) . '.' . $msgImg->getClientOriginalExtension();
                $path = public_path($chatPath);
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $imagePath = $chatPath . $imgName;
                $madeImage->save($imagePath);
                $chat['image'] = $imagePath;
            }
            $chat['text'] = $msg['text'];
            return Chat::create($chat);
        }
    }

}
