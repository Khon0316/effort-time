<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Incorrect Email or Password',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $request->user();

        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }
}
