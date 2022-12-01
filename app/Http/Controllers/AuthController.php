<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'message' => 'Sai tài khoản hoặc mật khẩu.',
            ], 422);
        }

        return response()->json([
            'message' => 'Đăng nhập thành công.',
            'status' => 'success',
            'user' => [
                "id" => Auth::user()->id,
                "name" => Auth::user()->name,
                "email" => Auth::user()->email,
                "role" => Auth::user()->getRoleNames()[0],
            ],

            'token' => $token,
            'type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('User');

        return response()->json([
            'status' => 'success',
            'user' => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "role" => $user->getRoleNames()[0],
            ],
        ]);
    }
}
