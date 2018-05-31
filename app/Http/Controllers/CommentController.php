<?php

namespace App\Http\Controllers;

use App\Repository\CommentRepository;
use App\Repository\MapRepository;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
{
    protected $commentRepository;
    protected $mapRepository;

    /**
     * CommentController constructor.
     * @param $commentRepository
     * @param $mapRepository
     */
    public function __construct(CommentRepository $commentRepository,MapRepository $mapRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->mapRepository = $mapRepository;
    }


    public function showComments($markerId){
        $comments = $this->commentRepository->show($markerId);

        return response()->json($comments);
    }

    public function showMyComments(){
        $user_id = auth()->guard('api')->user()->id;
        $comments = $this->commentRepository->showByUser($user_id);

        return response()->json($comments);
    }



    public function addComments(){

        $comment = $this->commentRepository->create([
            'user_id' =>  auth()->guard('api')->user()->id,
            'marker_id' => \request('marker_id'),
            'body' => \request('body'),
        ]);

        if($comment)
        {
            $mark = $this->mapRepository->find(request('marker_id'));
            $mark->increment('comments_count');
            return response()->json('success!');
        }
        else{
            return response()->json('failed!!');
        }

    }
}
