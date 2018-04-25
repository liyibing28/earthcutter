<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class FavoriteController extends Controller
{
    public function addFavorite($markerId){
        $user_id = auth()->guard('api')->user()->id;

        Auth::user()->addFavoriteThis($markerId);

        $is_favorited = Auth::user()->followed($markerId);

        return response()->json($is_favorited);
    }

    public function isFavorited($markerId){
        $is_favorited = Auth::user()->followed($markerId);

        return response()->json($is_favorited);
    }
}
