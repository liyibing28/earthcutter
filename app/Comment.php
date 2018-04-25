<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";

    protected $fillable = ['body','user_id','marker_id',];

    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }
}
