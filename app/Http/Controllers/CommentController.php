<?php

namespace App\Http\Controllers;

use App\Repository\CommentRepository;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{
    protected $commentRepositry;

    /**
     * CommentController constructor.
     * @param $commentRepositry
     */
    public function __construct(CommentRepository $commentRepositry)
    {
        $this->commentRepositry = $commentRepositry;
    }


    public function showComments($markerId){
        $comments = $this->commentRepositry->show($markerId);

        return response()->json($comments);
    }

    public function showMyComments(){
        $user_id = auth()->guard('api')->user()->id;
        $comments = $this->commentRepositry->showByUser($user_id);

        return response()->json($comments);
    }



    public function addComments(){

        $comment = $this->commentRepositry->create([
            'user_id' =>  auth()->guard('api')->user()->id,
            'marker_id' => \request('marker_id'),
            'body' => \request('body'),
        ]);

        if($comment)
        {
            return response()->json('success!');
        }
        else{
            return response()->json('failed!!');
        }

    }
}
