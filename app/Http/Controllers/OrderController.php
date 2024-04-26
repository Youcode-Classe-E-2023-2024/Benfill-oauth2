<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use Exception;
use Srmklive\PayPal\Services\PayPal;

class OrderController extends Controller
{
    function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only('order', 'lead');
        $validator = Validator::make($data, [
            'lead' => 'required',
            'order' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the order in your system
        $order = Order::create([
            'pack_id' => $data['order']['pack']['id'],
            'lead_id' => $data['lead']['id'],
            'total' => $data['order']['total'] * 100,
            'fees' => $data['order']['fees'] * 100,
            'userIp' => $data['order']['userIp'],
            'payTotal' => $data['order']['payTotal'] ? 'yes' : 'no',
            'paid' => 'no',
            'domiciliation' => $data['order']['domiciliation']['duration'] ?? 'none',
        ]);

        // PayPal integration
        try {
            $provider = new PayPal();
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => 'http://localhost:3006/services/creation_sarl/orderConfirmed',
                    "cancel_url" => 'http://localhost:3006/404'
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD", // Change as needed
                            "value" => $data['order']['total'] / 10, // Main currency unit
                        ]
                    ],
                ],
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                // Get the PayPal approval URL
                $approveUrl = null;
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        $approveUrl = $links['href'];
                        break;
                    }
                }

                return response()->json(['success' => 'Order created', 'approveUrl' => $approveUrl, 'order' => $order], 200);
            } else {
                return response()->json([
                    'error' => 'Failed to create PayPal order',
                    'details' => $response['message'] ?? 'Unknown error',
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred during PayPal integration',
                'message' => $e->getMessage(),
                'details' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'code' => $e->getCode(),
                ],
            ], 500);
        }
    }

    function getMyOrders(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->input('id');
        $validator = Validator::make([$id], [
            'id' => 'required|numeric|exists:orders',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = Order::with('lead')->find($id);
        return response()->json(['success' => 'Order created', 'order' => $order], 200);

    }
}
