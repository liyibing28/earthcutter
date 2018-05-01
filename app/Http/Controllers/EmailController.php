<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Auth;


class EmailController extends Controller
{
    public function RegisterVerify($token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if (is_null($user))     //获取到空值，直接跳转到首页
        {
            //flash('邮箱验证失败', 'danger');
            return redirect('http://earthcutter.test/');

        }

        $user->is_active = 1;
        $user->confirmation_token = str_random(40);
        $user->save();
        Auth::login($user);
        //ncurses_flash('邮箱验证成功，欢迎使用!', 'success');

        return redirect('http://earthcutter.test/');
    }
}
