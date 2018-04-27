<?php

namespace App\Http\Controllers;

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
        $file = $request->file('img');
        $user = auth()->guard('api')->user();

        //$filename = md5(time().$user->id).'.'.$file->getClientOriginalExtension();

        $filename = Storage::disk('upyun')->put('/avatars',$file);

        //$file->move(public_path('avatars'),$filename);

        $user->avatar = 'http://'.config('filesystems.disks.upyun.domain').'/'.$filename;

        $user->save;

        if(is_null($user)){
            return response()->json('user is null');
        }

        return response()->json([
            'filename' => $filename,
            'path' => auth()->guard('api')->user()->avatar]);
    }

    public function getUserById($userId)
    {
        $user = $this->userRepository->findUserById($userId);

        return response()->json($user);
    }
}
