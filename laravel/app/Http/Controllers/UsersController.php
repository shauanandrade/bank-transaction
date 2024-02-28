<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message'=>'opa'
        ]);
    }
}
