<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;

class UsersController extends Controller
{
    public function changAvatar(){
        $file = \request('files');
        $filename = md5(time().auth()->guard('api')->user()->id).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('avatars'),$filename);

        auth()->guard('api')->user()->avatar = asset(public_path('avatars/'.$filename));

        auth()->guard('api')->user()->save;

        return ['user' => auth()->guard('api')->user()->avatar];
    }
}