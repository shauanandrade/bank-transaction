<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse as BaseJsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except'=>['login','logout']]);
    }
    public function login(): BaseJsonResponse
    {
        $credentials  = request(['email','password']);

        if(! $token = auth()->attempt($credentials)){
            return response()->json([
                'error'=>'Unauthorized'
            ],401);
        }
        return $this->responseWithToken($token);
    }

    public function refresh(): BaseJsonResponse
    {
        $token = auth()->refresh();
        return $this->responseWithToken($token);
    }

    public function logout(): BaseJsonResponse
    {
        auth()->logout();
        return response()->json([
            'message'=>'Logout with success!'
        ],200);
    }

    protected function responseWithToken($token): BaseJsonResponse
    {
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->factory()->getTTL() * 360
        ]);
    }
}
