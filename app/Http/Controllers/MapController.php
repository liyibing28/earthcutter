<?php

namespace App\Http\Controllers;

use App\Repository\MapRepository;
use Illuminate\Http\Request;
use Auth;

class MapController extends Controller
{
    protected $mapRepository;

    /**
     * MapController constructor.
     * @param $mapRepository
     */
    public function __construct(MapRepository $mapRepository)
    {
        $this->mapRepository = $mapRepository;
    }


    public function create(){
        $data  = [
            'mark_type' => request('markerType'),
            'title' => request('title'),
            'body' => \request('body'),
            'is_hidden' => \request('isHidden'),
            'user_id' => auth()->guard('api')->user()->id,
            'latitude' => \request('lat'),
            'longitude' => \request('lng'),
        ];

        $this->mapRepository->create($data);

        return response()->json([
            'status' => true,
            'message' => 'add marker success',
        ]);


    }
}
