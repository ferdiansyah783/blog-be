<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError('Invalid credentials', 401);
        }

        $user = Auth::user();
        $token = $user->createToken('blog-token')->plainTextToken;

        return $this->sendResponse([
            'accessToken' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse(null, 'Logged out');
    }

    public function me(Request $request)
    {
        return $this->sendResponse($request->user());
    }
}
