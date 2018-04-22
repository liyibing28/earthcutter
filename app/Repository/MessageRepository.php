<?php
/**
 * Created by PhpStorm.
 * User: liyibing
 * Date: 2018/4/22
 * Time: 下午10:06
 */

namespace App\Repository;


use App\Message;

class MessageRepository
{
    public function create(array $attributes){
        return Message::create($attributes);
    }
}