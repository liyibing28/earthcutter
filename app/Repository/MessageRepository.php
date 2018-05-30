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

    public function deleteByUser($user, $friend){
        $messages = Message::where([
            ['user', $user],
            ['friend' , $friend]
        ]);

        return $messages->delete();
    }

    public function deleteByMessage($user, $messageId){
        return Message::destroy($messageId);

    }

    public function deleteByFriend($user,$friend){
        $messages = Message::where([['user',$user],['friend',$friend]])->get();
        return $messages->delete();
    }

    public function showByUserAndFriend($user, $friend){
        return Message::where([['user',$user],['friend',$friend]])->with('fromUser')->latest()->get();
    }


}