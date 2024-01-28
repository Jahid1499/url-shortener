<?php

namespace App\Http\Controllers\Api;

use App\Helper\JWTToken;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function Login(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $user = User::where('email', $request->input('email'))->first();

        if ($user == null)
        {
            return response()->json(['error' => 'User not found'], 422);
        }

//        return response()->json(Hash::check($request->input('password'), $user->password));

        if(!Hash::check($request->input('password'), $user->password))
        {
            return response()->json(['error' => 'Incorrect password'], 422);
        }

        $token = JWTToken::CreateToken($user->email, $user->id);
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);

    }

    public function Registration(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $newUser = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'status' => "active",
            ]);

            $user = User::findOrFail($newUser->id);
            $token = JWTToken::CreateToken($user->email, $user->id);
            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'errors' => "Failed to registration",
            ], 422);
        }
    }
}
