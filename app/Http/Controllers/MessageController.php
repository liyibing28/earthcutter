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
        $message = $this->messageRepository->create([
           'to_user_id' => 60,
           'user' => auth()->guard('api')->user()->id,
           'friend' => 60,
           'from_user_id' => auth()->guard('api')->user()->id,
           'from_user_name' => auth()->guard('api')->user()->name,
           'body' => \request('body'),
        ]);

        $message = $this->messageRepository->create([
            'from_user_id' => auth()->guard('api')->user()->id,
            'to_user_id' => 60,
            'user' => 60,
            'friend' => auth()->guard('api')->user()->id,
            'from_user_name' => auth()->guard('api')->user()->name,
            'body' => \request('body'),
        ]);


        if($message){
            return response()->json(['status'=> true]);
        }

        return response()->json(['status'=> false]);

    }

    public function messages(){
        $authId = auth()->guard('api')->user()->id;
        $messages = Message::where('user',$authId)->with('fromUser')->get()->groupBy('user');
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


}
