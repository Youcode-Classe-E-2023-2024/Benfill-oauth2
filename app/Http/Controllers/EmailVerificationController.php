<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;
use App\Models\Lead;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    function firstLogin(Request $request): \Illuminate\Http\JsonResponse
    {
        $email = $request->input('email');


        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $token = Str::random(8);

        $checkRequest = EmailVerification::where('email', $email)
            ->where('status', 'inProcess')
            ->where('expiration_date', '>=', Carbon::now())
            ->first();
        if (isset($checkRequest)) {
            $checkRequest->status = 'deleted';
            $checkRequest->save();
        }


        $emailRequest = EmailVerification::create([
            'email' => $email,
            'token' => Hash::make($token),
            'status' => 'inProcess',
            'expiration_date' => Carbon::now()->addHour()
        ]);
        /*        Mail::to($email)->send(new PasswordRecoveryMail([
                    'link' => $link,
                ]));*/
        $response = [
            'status' => 'success',
            'message' => 'Request is created successfully.',
            'id' => $emailRequest->id,
            'token' => $token
        ];
        return response()->json($response);

    }

    function validEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only('email', 'token');
        $validator = Validator::make($data, [
            'email' => 'required|exists:email_verifications',
            'token' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }
        $emailRequests = EmailVerification::where('email', $data['email'])
            ->get()
            ->first();
        if (!$emailRequests) {
            return response()->json(['status' => 'error', 'message' => "Invalid email"], 404);
        }

        if (!Hash::check($data['token'], $emailRequests->token)) {
            return response()->json(['status' => 'error', 'message' => "Invalid request token"], 404);
        }

        $emailRequests->status = 'valid';
        $emailRequests->save();
        $lead = Lead::where('managerEmail', $data['email'])
            ->get()
            ->first();
        User::create([
            'email' => $data['email'],
            'name' => $lead ? $lead->managerEmail : substr($data['email'], 0, strpos($data['email'], '@')),
            'password' => Hash::make(Str::random(16))
        ]);
        return response()->json(['status' => 'success', 'message' => "Code valid"], 200);

    }
}
