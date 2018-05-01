<?php
/**
 * Created by PhpStorm.
 * User: liyibing
 * Date: 2018/4/27
 * Time: 下午5:19
 */

namespace App\Repository;


use App\User;

class UserRepository
{
    public function findUserById($userId)
    {
        return User::find($userId)->with('hasMarkers')->get();
        //return User::where('id',$userId)->get();
    }
}