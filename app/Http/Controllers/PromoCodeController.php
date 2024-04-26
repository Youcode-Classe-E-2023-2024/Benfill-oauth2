<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromoCodeController extends Controller
{
    function checkPromoCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promoCode' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $checker = PromoCode::where('reduction_code', $request->promoCode)->first();
        if ($checker)
            return response()->json(['status' => 'success', 'message' => 'Code Verified',
                'promo' => $checker
            ], 202);

        return response()->json(['status' => 'failed', 'message' => 'Code Incorrect'], 422);

    }
}
