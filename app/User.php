<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded=[];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string'
    ];

    /**
     * Get the Profile of the user
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(){
        return $this->hasOne('App\Profile','user_id', 'id');
    }

    /**
     * Get Friend Requests of the user
     * @return  FriendRequest collection
     */
    public function friends(){
        return $this->hasMany('App\FriendRequest')
            ->merge($this->hasMany('App\FriendRequest','friend_id', 'id'));
    }

    /**
     * Get posts made by the user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(){
        return $this->hasMany('App\Content','user_id', 'id')
            ->where('type','=','post')
            ->orderBy('created_at','DESC');;
    }

}
