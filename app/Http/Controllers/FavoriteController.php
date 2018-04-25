<?php

namespace App\Http\Controllers;

use App\Repository\FavoriteRepository;
use Illuminate\Http\Request;
use Auth;

class FavoriteController extends Controller
{
    protected $favoriteRepository;

    /**
     * FavoriteController constructor.
     * @param $favoriteRepository
     */
    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }


    public function addFavorite($markerId){
        Auth::user()->addFavoriteThis($markerId);

        $is_favorited = Auth::user()->followed($markerId);

        return response()->json($is_favorited);
    }

    public function isFavorited($markerId){
        $is_favorited = Auth::user()->followed($markerId);

        return response()->json($is_favorited);
    }

    public function showFavorite(){
        $user_id = auth()->guard('api')->user()->id;

        $favorite = $this->favoriteRepository->show($user_id);

        return response()->json($favorite);
    }
}
