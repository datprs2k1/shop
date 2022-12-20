<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\User\ChangePassword;
use App\Http\Requests\User\ChangeRequest;
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

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Đăng xuất thành công.',
        ], 200);
    }

    public function changeInfo(ChangeRequest $request)
    {
        $user = User::find(Auth::user()->id);

        $user->name = $request->name;

        $user->save();

        return response()->json([
            'message' => 'Cập nhật thông tin thành công.'
        ], 200);
    }

    public function getInfo()
    {
        $user = Auth::user();

        return response()->json([
            'user' => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "role" => $user->getRoleNames()[0],
            ],
        ]);
    }

    public function changePassword(ChangePassword $request)
    {
        $user = User::find(Auth::user()->id);

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Mật khẩu cũ không đúng.',
            ], 422);
        }

        $user->password = Hash::make($request->new_password);

        $user->save();

        return response()->json([
            'message' => 'Đổi mật khẩu thành công.',
        ], 200);
    }
}
