<?php

namespace App\Http\Controllers;

use App\Repository\MapRepository;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class MapController extends Controller
{
    protected $mapRepository;

    protected $user;

    /**
     * MapController constructor.
     * @param $mapRepository
     */
    public function __construct(MapRepository $mapRepository)
    {
        $this->mapRepository = $mapRepository;
        $this->user = auth()->guard('api')->user();
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
            'message' => $this->user,
        ]);


    }

    public function update($id){

//        return response()->json([
//            'code' => 100
//        ]);
        $data  = [
            'mark_type' => request('markerType'),
            'title' => request('title'),
            'body' => \request('body'),
            'is_hidden' => \request('isHidden'),
        ];

        $return = $this->mapRepository->update($id,$data);
        if($return){
            return response()->json([
                'code' => 200,
                'info' => $return,
            ]);
        }else{
            return response()->json([
                'code' => 401,
                'info' => 'update error!!',
            ]);
        }

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
        $data = $this->mapRepository->findWithUser($markerId);
        //$data = null;
        return response()->json($data);
    }

    public function showMyMarkers(){
        $user_id = auth()->guard('api')->user()->id;
        $data = $this->mapRepository->findUserMarkers($user_id);
        //$data = null;
        return response()->json($data);
    }

    public function uploadImage(Request $request){
        $file = $request->file('img');
        $filename = Storage::disk('upyun')->put('/markers/image',$file);
        $filePath =  'http://'.config('filesystems.disks.upyun.domain').'/'.$filename;

        return response()->json([
            'code' => '200',
            'info' => $filePath,
        ]);
    }

    public function delete($id){
        $marker = $this->mapRepository->find($id);
        if($marker->delete()){
            return response()->json([
                'status' => 200,
                'info' => 'delete success!'
            ]);
        }

    }

}
