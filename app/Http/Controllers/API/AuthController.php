<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AuthController extends BaseController
{
    public function createToken(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where(['email' => $request->input('email')])->first();
            $token = $user->createToken($user->email);
            return $this->sendResponse(['token' => $token], 'success');
        } else {
            return $this->sendError("Login failed");

        }
    }
}
