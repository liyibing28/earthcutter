<?php

namespace App\Http\Controllers;
//require_once('/vendor/autoload.php');

use Upyun\Upyun;
use Upyun\Config;


use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    protected $userRepository;

    /**
     * UsersController constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function changAvatar(Request $request){
        // 创建实例
        //$bucketConfig = new Config('earthcutter-demo', 'earthcutter', 'earthcutter');
        //$client = new Upyun($bucketConfig);


        $file = $request->file('img');
        //return time();

        $user = auth()->guard('api')->user();



        //$filename = md5(time().$user->id).'.'.$file->getClientOriginalExtension();

        //$res = $client->write('/avatars/'.$filename, $file);

        //return $res;

        $filename = Storage::disk('upyun')->put('/avatars',$file);

        //if(is_null($user)){
        //    return response()->json('user is null');
        //}



        ///$file->move(public_path('avatars'),$filename);

        $user->avatar = 'http://'.config('filesystems.disks.upyun.domain').'/'.$filename;

        //$user->avatar = asset(public_path('/avatars/').$filename);

        $user->save();

        return response()->json([
            'path' => $user->avatar,
        ]);


    }

    public function getUserById($userId)
    {
        $user = $this->userRepository->findUserById($userId);

        return response()->json($user);
    }
}
