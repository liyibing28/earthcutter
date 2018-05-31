<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Auth;

class FollowersController extends Controller
{
    protected $user;

    /**
     * FollowersController constructor.
     * @param $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    public function index($id){
        $user = $this->user->byId($id);
        $followers = $user->followersUser() ->pluck('follower_id')->toArray();
        if(in_array(auth()->guard('api')->user()->id, $followers)){
            return response()->json([
                'followed' => true,
            ]);
        }
        return response()->json([
            'followed' => false,
        ]);

    }

    public function follow($id){
        $userToFollow = $this->user->byId($id);
        $followed = auth()->guard('api')->user()->followThisUser($userToFollow->id);

        if(count($followed['attached']) > 0){
            return response()->json([
                'followed' => true,
            ]);
        }

        return response()->json([
            'followed' => false,
        ]);

    }
}
