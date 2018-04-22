<?php

namespace App\Http\Controllers;

use App\Repository\MessageRepository;
use Illuminate\Http\Request;
use Auth;

class MessageController extends Controller
{
    protected $message;

    /**
     * MessageController constructor.
     * @param $message
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }


    public function sendMessage()
    {
        $message = $this->message->create([
           'to_user_id' => 37,
           'from_user_id' => auth()->guard('api')->user()->id,
           'body' => \request('body'),
        ]);
        if($message){
            return response()->json(['status'=> true]);
        }

        return response()->json(['status'=> false]);

    }
}
