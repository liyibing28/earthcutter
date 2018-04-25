<?php
/**
 * Created by PhpStorm.
 * User: liyibing
 * Date: 2018/4/24
 * Time: 下午10:54
 */

namespace App\Repository;


use App\Comment;

class CommentRepository
{
    public function show($markerId){
        return Comment::where('marker_id',$markerId)->with('User')->get();
    }

    public function showByUser($user_id){
        return Comment::where('user_id',$user_id)->with('Map')->get();
    }

    public function create(array $attributes){
        return Comment::create($attributes);
    }


    public function delete($markerId){

    }

    public function update($attribute,$markerId){

    }
}