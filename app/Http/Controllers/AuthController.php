<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Closure;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use JWTAuth;
use Validator;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'FIO' => 'required',
            'lizo' => 'required|in:fiz,yr',
            'Pincode' => 'required|string|confirmed|min:2',
            'AllBalance' => 'required|integer',
            'role' => 'required|in:admin,user', // Добавляем проверку роли
        ]);
        if($validator->fails()) {
            response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'FIO' => $request->input('FIO'),
            'lizo' => $request->input('lizo'),
            'Pincode' => Hash::make($request->input('Pincode')),
            'AllBalance' => $request->input('AllBalance'),
            'role' => $request->input('role'), // Устанавливаем роль
        ]);
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User successfully registered!',
            'user' => $user,
            'token' => $token
        ], 200);
    }
    public function registerWeb(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'FIO' => 'required',
            'lizo' => 'required|in:fiz,yr',
            'Pincode' => 'required|string|confirmed|min:2',
            'AllBalance' => 'required|integer',
            'role' => 'required|in:admin,user', // Добавляем проверку роли
        ]);
        if($validator->fails()) {
            response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'FIO' => $request->input('FIO'),
            'lizo' => $request->input('lizo'),
            'Pincode' => Hash::make($request->input('Pincode')),
            'AllBalance' => $request->input('AllBalance'),
            'role' => $request->input('role'), // Устанавливаем роль
        ]);
        $token = JWTAuth::fromUser($user);
        $validator = Validator::make($request->all(),
        [
            'FIO' => 'required',
            'lizo' => 'required|in:fiz,yr',
            'Pincode' => 'required|string|confirmed|min:2',
            'AllBalance' => 'required|integer',
            'role' => 'required|in:admin,user', // Добавляем проверку роли
        ]);
        if($validator->fails()) {
            response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'FIO' => $request->input('FIO'),
            'lizo' => $request->input('lizo'),
            'Pincode' => Hash::make($request->input('Pincode')),
            'AllBalance' => $request->input('AllBalance'),
            'role' => $request->input('role'), // Устанавливаем роль
        ]);
        $token = JWTAuth::fromUser($user);
        $request->headers->set('Authorization', 'Bearer ' . $token);
        return redirect()->route('login');
        // После успешной регистрации, перенаправляем на страницу входа
       
    }
    public function showRegistrationForm()
    {
        return view('register');
    }
    

   




    

    public function login(Request $request) {
        $user = User::where('FIO', $request->input('FIO'))->first();
    
        if ($user && Hash::check($request->input('Pincode'), $user->Pincode)) {
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
            'expires_in' => auth('api')->factory()->getTTL() * 600000 //mention the guard name inside the auth fn
        ]);
    }


    public function showLoginForm()
    {
        return view('login'); // Предполагая, что ваш файл представления для формы входа назван 'login.blade.php'
    }

    public function loginWeb(Request $request)
    {
        $user = User::where('FIO', $request->input('FIO'))->first();
    
        if ($user && Hash::check($request->input('Pincode'), $user->Pincode)) {
            $token = JWTAuth::fromUser($user);
            $request->headers->set('Authorization', $token);
            return redirect()->route('home', ['token' => $token]);
        }
    
        return response()->json(['error' => 'Invalid credentials'], 401);
        
    }

    

    
}