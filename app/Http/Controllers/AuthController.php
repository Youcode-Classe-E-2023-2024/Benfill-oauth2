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

        $data['token'] = $user->createToken($request->email)->accessToken;
        $data['user'] = $user;

        $response = [
            'status' => 'success',
            'message' => 'User is created successfully.',
            'data' => $data,
        ];
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
        // Check email exist
        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $data['token'] = $user->createToken($request->email)->accessToken;
        $data['user'] = $user;

        $response = [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'data' => $data,
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
    auth()->user()->tokens()->delete();
    return response()->json([
        'status' => 'success',
        'message' => 'User is logged out successfully'
    ], 200);
}
}
