<?php

namespace App\Http\Controllers;
use App\Helper\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
        {
            $response = (new UserService($request->email, $request->password))->register($request->devicename);
            return response()->json($request);
        }

        public function login(Request $request)
        {

        }
}