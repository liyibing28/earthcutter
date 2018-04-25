<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'user_map';

    protected $fillable = ['user_id','map_id'];

    public function Map(){
        return $this->belongsTo(Map::class,'map_id');
    }
}
