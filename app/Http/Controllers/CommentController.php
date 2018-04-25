<?php

namespace App\Http\Controllers;

use App\Repository\CommentRepository;
use Illuminate\Http\Request;

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


    public function show($markerId){
        $this->commentRepositry->show($markerId);
    }
}
