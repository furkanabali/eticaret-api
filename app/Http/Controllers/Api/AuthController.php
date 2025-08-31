<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|min:2',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasyon Hatası',
                'errors' => $e->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı başarıyla kaydedildi.',
            'data' => [
                'user' => $user
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasyon Hatası',
                'errors' => $e->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Yetkisiz erişim. E-posta veya şifre yanlış.',
                'errors' => []
            ], 401);
        }

        $user = Auth::guard('api')->user();

        Log::channel('user_logins')->info('Kullanıcı başarıyla giriş yaptı.', [
            'user_id' => $user->id,
            'username' => $user->name,
            'email' => $user->email,
            'login_time' => now()->toDateTimeString(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Giriş başarılı.',
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
            ]
        ], 200);
    }

    public function profile()
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
             return response()->json(['success' => false, 'message' => 'Yetkisiz erişim.'], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil bilgileri başarıyla getirildi.',
            'data' => [
                'user' => Auth::user()
            ]
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
             return response()->json(['success' => false, 'message' => 'Yetkisiz erişim.'], 401);
        }

        try {
            $request->validate([
                'name' => 'min:2',
                'email' => 'email|unique:users,email,'.$user->id,
                'password' => 'min:8|nullable',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasyon Hatası',
                'errors' => $e->errors()
            ], 422);
        }

        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil bilgileri başarıyla güncellendi.',
            'data' => [
                'user' => $user
            ]
        ], 200);
    }
}