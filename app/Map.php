<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = ['mark_type','title','body','longitude','latitude','user_id'];
}
