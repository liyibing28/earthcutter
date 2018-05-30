<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['from_user_id','to_user_id','body','user','friend','from_user_name','title'];

    public function withFriend(){
        return $this->belongsTo(User::class, 'friend');
    }

    //定义与User的关系
    public function fromUser(){
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function toUser(){
        return $this->belongsTo(User::class,'to_user_id');
    }
}
