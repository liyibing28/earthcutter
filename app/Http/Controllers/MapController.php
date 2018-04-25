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

    public function show(){
        $data = [
            'north' => \request('north'),
            'east' => \request('east'),
            'south' => \request('south'),
            'west' => \request('west'),
        ];

        $markers = $this->mapRepository->show($data);

        return response()->json($markers);
    }

    public function showMarker($markerId){
        $data = $this->mapRepository->find($markerId);
        //$data = null;
        return response()->json($data);
    }

    public function showMyMarkers(){
        $user_id = auth()->guard('api')->user()->id;
        $data = $this->mapRepository->findUserMarkers($user_id);
        //$data = null;
        return response()->json($data);
    }
}
