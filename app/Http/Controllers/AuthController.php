<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/register",
     *     summary="Register a new user",
     *     tags={"Authentication"},
     *     @OA\Response(response=200, description="Successful registration"),
     *     @OA\Response(response=400, description="Invalid request")
     * )
     */
    function register(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $request;
        $user = [
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => Hash::make($data["password"])
        ];

        User::create($user);

        Auth::login($user);
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->token = $token;
        $user->save();
        $status = "success";
        $response = ['user' => Auth::user(),
            'token' => $token,
            'status' => $status];
        return response()->json($response);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Login user",
     *     tags={"Authentication"},
     *     @OA\Response(response=200, description="Successful login"),
     *     @OA\Response(response=400, description="Invalid credentials")
     * )
     */
    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;
            $user->save();
            $status = "success";
            $response = [
                'user' => $user,
                'token' => $token,
                'status' => $status
            ];
            return response()->json($response);
        }

        $response = [
            "errors" => ["email" => ["The provided credentials do not match our records."]]
        ];
        return response()->json($response);

    }


    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Logout user",
     *     tags={"Authentication"},
     *     @OA\Response(response=200, description="Successful logout"),
     *     @OA\Response(response=400, description="Invalid token")
     * )
     */
    function logout(Request $request)
    {
        $user = User::where('token', $request->token)->get()->first();
        if (isset($user)) {
            $user->token = '';
            $user->save();
            $user->tokens()->delete();
            return response()->json(["status" => 'success']);
        }
        return response()->json(["status" => "something's wrong"]);
    }
}
