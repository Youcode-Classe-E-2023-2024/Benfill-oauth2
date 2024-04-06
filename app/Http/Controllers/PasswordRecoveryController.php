<?php

namespace App\Http\Controllers;

use App\Mail\PasswordRecoveryMail;
use App\Models\PasswordRecovery;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasswordRecoveryController extends Controller
{
    function passwordRecoveryRequest(Request $request)
    {
        $email = $request->only('email');

        $validator = Validator::make($email, [
            'email' => 'required|email|exists:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_id = User::where('email', $email)
            ->pluck('id')
            ->first();

        $token = Str::random(8);

        $checkRequest = PasswordRecovery::where('user_id', $user_id)
            ->get()
            ->first();
        if (isset($checkRequest))
            $checkRequest->delete();

        $passwordRequest = PasswordRecovery::create([
            'user_id' => $user_id,
            'token' => Hash::make($token)
        ]);
        /*        Mail::to($email)->send(new PasswordRecoveryMail([
                    'link' => $link,
                ]));*/
        $response = [
            'status' => 'success',
            'message' => 'Request is created successfully.',
            'id' => $passwordRequest->id,
            'token' => $token
        ];
        return response()->json($response);

    }

    function passwordRecoveryChange(Request $request)
    {
        $data = $request->only('token', 'id', 'password', 'password_confirmation');

        $validator = Validator::make($data, [
            'id' => 'required|exists:password_recovery_requests',
            'password' => 'required|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $passwordRequests = PasswordRecovery::find($data['id']);

        if (!$passwordRequests) {
            return response()->json(['status' => 'error', 'message' => "Invalid recovery request ID"], 404);
        }

        $user = User::find($passwordRequests->user_id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => "User not found"], 404);
        }

        if (!Hash::check($data['token'], $passwordRequests->token)) {
            return response()->json(['status' => 'error', 'message' => "Invalid token"], 403);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        $passwordRequests->delete();

        return response()->json(['status' => 'success', 'message' => 'Password changed successfully']);
    }
}
