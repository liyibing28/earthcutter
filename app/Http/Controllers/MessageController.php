<?php

namespace App\Http\Controllers;

use App\Message;
use App\Repository\MessageRepository;
use Illuminate\Http\Request;
use Auth;

class MessageController extends Controller
{
    protected $messageRepository;

    /**
     * MessageController constructor.
     * @param $message
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->middleware('auth');
    }


    public function sendMessage()
    {
        $message1 = $this->messageRepository->create([
           'to_user_id' => \request('to_user_id'),
           'user' => auth()->guard('api')->user()->id,
           'friend' => \request('to_user_id'),
           'from_user_id' => auth()->guard('api')->user()->id,
           'from_user_name' => auth()->guard('api')->user()->name,
           'title' => \request('title'),
           'body' => \request('body'),
        ]);

        $message2 = $this->messageRepository->create([
            'from_user_id' => auth()->guard('api')->user()->id,
            'to_user_id' => \request('to_user_id'),
            'user' => \request('to_user_id'),
            'friend' => auth()->guard('api')->user()->id,
            'from_user_name' => auth()->guard('api')->user()->name,
            'title' => \request('title'),
            'body' => \request('body'),
        ]);


        if($message1 && $message2){
            return response()->json(['status'=> true]);
        }

        return response()->json(['status'=> false]);

    }

    public function messages(){
        $authId = auth()->guard('api')->user()->id;
        $messages = Message::where('user',$authId)->with('withFriend')->latest()->get()->groupBy('friend');
        //$messages = Auth::user()->messages->with('fromUser')->groupBy('user');
        return response()->json($messages);
    }

    public function show($user_id){
        $authId = auth()->guard('api')->user()->id;

        //$messages = Message::where([['user',$authId],['friend',$user_id]])->latest()->get();
        $messages = $this->messageRepository->showByUserAndFriend($authId, $user_id);

        return response()->json($messages);
    }

    public function deleteByUser($userId){
        $user = auth()->guard('api')->user()->id;
        return $this->messageRepository->deleteByUser($user, $userId);
    }

    public function deleteByMessage($messageId){
        $user = auth()->guard('api')->user()->id;
        return $this->messageRepository->deleteByMessage($user, $messageId);

    }


    public function deleteByFriend($friend){
        $user = auth()->guard('api')->user()->id;

        if($this->messageRepository->deleteByFriend($user,$friend)){
            return response()->json([
                'code' => 200,
                'info' => 'delete Sucess',
            ]);
        }else{
            return response()->json([
                'code' => 201,
                'info' => 'delete fail',
            ]);
        }
    }

}
