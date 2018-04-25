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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function favorite( ){
        return $this->belongsToMany(Map::class,'user_map')->withTimestamps();
    }

    public function addFavoriteThis($map){
         return $this->favorite()->toggle($map);
    }

    public function followed($map){ //用户已经收藏这个问题
        return !! $this->favorite()->where('map_id',$map)->count( );
    }

    public function messages(){
        return $this->hasMany(Message::class,'to_user_id');
    }
}
