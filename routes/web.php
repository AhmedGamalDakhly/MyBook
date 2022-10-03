<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/* Sign Up and Login Routes*/
Route::get('/login-form', 'LoginController@index' )->name('loginForm.route');
Route::post('/login-form/login', 'LoginController@login' )->name('login.route');
Route::get('/signup-form', 'SignupController@index' )->name('signupForm.route');
Route::post('/signup-form/signup', 'SignupController@signup' )->name('signup.route');

/* Website Main Page Routes*/
Route::middleware(['auth:login'])->group(function (){

    /* Home Page Routes*/
    Route::get('/', 'HomeController@index' )->name('home.route');

    /* Profile Page Routes*/
    Route::prefix('/profile')->group(function () {
        Route::get('/settings', 'ProfileController@showSettings' )->name('profile.settings.route');
        Route::post('/settings/change', 'ProfileController@changeSettings' )->name('profile.changeSettings.route');
        Route::get('/{id?}', 'ProfileController@index' )->name('profile.route');
        Route::post('/{id}/changeImg/{type}', 'ProfileController@changeImg' )->name('profile.changeImg.route');
    });

    /* Posts and Comments  Routes*/
    Route::post('/post', 'PostController@post' )->name('addNewPost.route');
    Route::post('/delete{contentID}', 'PostController@delete' )->name('deletePost.route');
    Route::post('/comment{postID}', 'PostController@comment' )->name('addNewComment.route');
    Route::post('/reply{commentID}', 'PostController@reply' )->name('addNewReply.route');
    Route::post('/share{postID}', 'PostController@share' )->name('sharePost.route');
    Route::post('/like{contentID}', 'likeController@like' )->name('like.route');

    /* Friends Page Routes*/
    Route::prefix('/friends')->group(function () {
        Route::get('', 'FriendController@index' )->name('friends.route');
        Route::post('/add/{friendID}', 'FriendController@addFriend' )->name('friends.add.route');
        Route::post('/unFriend/{friendID}', 'FriendController@unFriend' )->name('friends.unFriend.route');
        Route::post('/requests/approve/{friendID}', 'FriendController@approveFriendRequest' )->name('friends.approveRequest.route');
        Route::post('/requests/reject/{friendID}', 'FriendController@rejectFriendRequest' )->name('friends.rejectRequest.route');
    });

    /* groups Management  Routes*/
    Route::prefix('/groups')->group(function () {
        Route::get('', 'GroupController@index' )->name('groups.route');// get groups page
        Route::get('/create', 'GroupController@newGroupForm' )->name('groups.newGroupForm.route');//get page where to create new group
        Route::post('/create', 'GroupController@create' )->name('groups.create.route');// create new group
    });

    /* group Page Routes*/
    Route::prefix('/group/{groupID}')->group(function () {
        Route::get('', 'GroupController@showGroup' )->name('group.route');
        Route::post('/changeCover', 'GroupController@changeCover' )->name('group.changeCover.route');//change group cover
        Route::get('/members', 'GroupController@showMembers' )->name('group.members.route');//get group members and requests
        Route::post('/members/add/{memberID}', 'GroupController@addMember' )->name('group.addMember.route');//add  member to group
        Route::post('/members/remove/{memberID}', 'GroupController@removeMember' )->name('group.removeMember.route');//remove  member from group
        Route::post('/members/requestJoin', 'GroupController@requestJoin' )->name('group.requestJoin.route');// send a group join request
        Route::post('/members/cancelJoinRequest', 'GroupController@cancelJoinRequest' )->name('group.cancelJoinRequest.route');// send a group join request
        Route::post('/members/acceptRequest/{memberID}', 'GroupController@acceptRequest' )->name('group.acceptRequest.route');// handle(approve / reject) group request
        Route::post('/members/rejectRequest/{memberID}', 'GroupController@rejectRequest' )->name('group.acceptRequest.route');// handle(approve / reject) group request
        Route::post('/members/invite/{memberID}', 'GroupController@invite' )->name('group.invite.route');// send a group join request
        Route::post('/members/acceptInvite', 'GroupController@acceptInvite' )->name('group.acceptInvite.route');
        Route::post('/members/rejectInvite', 'GroupController@rejectInvite' )->name('group.rejectInvite.route');
        Route::post('/members/exit', 'GroupController@exitGroup' )->name('group.exitGroup.route');
    });

    /* Messanger (Chat App) Routes */
    Route::get('/messanger/{friendID?}', 'ChatController@getChat' )->name('chat.route');
    Route::post('/messanger/sendMessage', 'ChatController@sendMessage' )->name('sendMessage.route');

    /*Notification Feature Routes*/
    Route::get('/notifications', 'NotificationController@index' )->name('notifications.route');
    Route::get('/notifications/content/{notificationID}', 'NotificationController@showContent' )->name('notifications.content.route');
    Route::post('/notifications/setSeen/{id}', 'NotificationController@setSeen' )->name('notifications.setSeen.route');

    /* Logout routes*/
    Route::get('/logout', 'LoginController@logout' )->name('logout.route');
    Route::get('/logout', 'LoginController@logout' )->name('logout.route');
});
