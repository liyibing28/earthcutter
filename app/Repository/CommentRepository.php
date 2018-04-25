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
        return Comment::where('marker_id',$markerId);
    }

    public function create($attribute){
        Comment::create($attribute);
    }
}