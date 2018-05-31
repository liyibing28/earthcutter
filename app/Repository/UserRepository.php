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
    public function findUserById($id)
    {
        return User::find($id)->with('hasMarkers')->get();
        //return User::where('id',$userId)->get();
    }

    public function byId($id){
        return User::find($id);
    }
}