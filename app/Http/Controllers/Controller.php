<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function success($message = null,$data= null){
        return response()->json([
            'status'=> 'success',
            'message'=>$message,
            'data'=>$data
        ]);
    }

    protected function error($message){
        return response()->json([
            'status'=> 'error',
            'message'=>$message
        ]);
    }
}
