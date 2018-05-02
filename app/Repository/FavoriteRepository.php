<?php
/**
 * Created by PhpStorm.
 * User: liyibing
 * Date: 2018/4/25
 * Time: 下午1:39
 */

namespace App\Repository;


use App\Favorite;

class FavoriteRepository
{
    public function show($user_id){
        return Favorite::where('user_id',$user_id)->with('Map','User')->get();
    }
}