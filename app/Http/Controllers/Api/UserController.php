<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'username' => 'required',//
            'password' => 'required',
        ]);

        if($validation->fails()){
            return $this->error($validation->errors()->first());
        }
        $loginInfo = [
            'username' => $request['username'],
            'password' => $request['password'],
        ];

        if (!Auth::attempt($loginInfo)){
            return $this->error('username or password incorrect');
        }

        $user = Auth::user();
        $user->api_token = $this->getToken();
        $user->update();

        return $this->success('',['api_token'=>$user->api_token]);

    }

    private function getToken()
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, 32);
    }
}
