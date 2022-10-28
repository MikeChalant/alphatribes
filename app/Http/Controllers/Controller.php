<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function appResponse(bool $status,string $type,mixed $message,mixed $data,int $statusCode)
    {
        return response()->json([
            'status'=>$status,
            'code'=>$statusCode,
            $type=>[
                'message'=>$message,
                'data'=>$data,
            ]
        ], $statusCode);
    }
}
