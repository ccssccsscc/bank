<?php
namespace App\ViewModels;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class AuthViewModel
{
    public function register(array $data)
    {
        $validator = Validator::make($data, [
            'FIO' => 'required',
            'lizo' => 'required|in:fiz,yr',
            'Pincode' => 'required|string|confirmed|min:2',
            'AllBalance' => 'required|integer',
            'role' => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'FIO' => $data['FIO'],
            'lizo' => $data['lizo'],
            'Pincode' => Hash::make($data['Pincode']),
            'AllBalance' => $data['AllBalance'],
            'role' => $data['role'],
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User successfully registered!',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function login(array $credentials)
    {
        $user = User::where('FIO', $credentials['FIO'])->first();

        if ($user && Hash::check($credentials['Pincode'], $user->Pincode)) {
            $token = JWTAuth::fromUser($user);
            return response()->json(['user' => $user, 'access_token' => $token, 'role' => $user->role]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 600000
        ]);
    }
}