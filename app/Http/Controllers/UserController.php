<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/users",
     *     summary="Get a list of users",
     *     tags={"Users"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    function index()
    {
        $users = User::all();
        return response()->json($users);
    }


    /**
     * @SWG\Post(
     *     path="/users",
     *     summary="Create New User",
     *     tags={"Users"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8'
        ]);
        /*        if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }*/
        $data = $request;
        $user = [
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => Hash::make($data["password"])
        ];

        $user = User::create($user);
        $status = "success";
        $response = ['user' => $user,
            'status' => $status];
        return response()->json($response);
    }


    /**
     * @SWG\Put(
     *     path="/users/{id}",
     *     summary="Update User",
     *     tags={"Users"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'password' => 'string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::find($id);

        if (isset($request->name)) {
            $user->name = $request->name;
        }
        if (isset($request->password)) {
            $user->name = $request->password;
        }

        $user->save();
        return response()->json([
            'status' => 'success'
        ]);
    }


    /**
     * @SWG\Delete(
     *     path="/users/{id}",
     *     summary="Delete User",
     *     tags={"Users"},
     *     @SWG\Response(response=200, description="Successful operation"),
     *     @SWG\Response(response=400, description="Invalid request")
     * )
     */
    function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }

    function assignRole(Request $request)
    {
        $user_id = $request->user_id;
        $role = $request->role;

        RoleController::assignRole($user_id, $role);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
