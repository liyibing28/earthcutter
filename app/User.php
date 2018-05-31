<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function favorite(){
        return $this->belongsToMany(Map::class,'user_map')->withTimestamps();
    }

    public function addFavoriteThis($map){
         return $this->favorite()->toggle($map);
    }

    public function followed($map){ //用户已经收藏这个问题
        return !! $this->favorite()->where('map_id',$map)->count( );
    }

    public function followers(){
        return $this->belongsToMany(self::class,'followers','follower_id', 'followed_id')->withTimestamps();
    }

    public function followersUser(){
        return $this->belongsToMany(self::class,'followers','followed_id', 'follower_id')->withTimestamps();
    }

    public function followThisUser($user){
        return $this->followers()->toggle($user);
    }

    public function messages(){
        return $this->hasMany(Message::class,'to_user_id');
    }

    public function hasMarkers(){
        return $this->hasMany(Map::class,'user_id');
    }
}
