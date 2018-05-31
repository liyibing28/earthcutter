<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class VotesController extends Controller
{
    public function users($id){
        $user = auth()->guard('api')->user()->id;
    }

    public function vote($id){

    }
}
