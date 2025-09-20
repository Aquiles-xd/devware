<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $array = [];
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        if (!$user = User::where('email', $data['email'])->first()) {
            return response()->json(['error' => 'E-mail e/ou senha incorretos!'], 401);
        }

        if (!Hash::check($data['password'], $user->password)) {
            return response()->json(['error' => 'E-mail e/ou senha incorretos!'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        $array['token'] = $token;
        $array['message'] = 'Login realizado com sucesso!';

        return response()->json($array, 202);
    }
    public function store(Request $request)
    {
        $array = [];
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $newUser = new User;
        $newUser->email = $data['email'];
        $newUser->password = Hash::make($data['password']);
        $newUser->save();

        $token = Auth::login($newUser);
        $array['token'] = $newUser->createToken('api-token')->plainTextToken;

        return response()->json($array, 202);
    }
}
