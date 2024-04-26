<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    function index()
    {
        $users = Lead::paginate(6);
        return response()->json($users);
    }

    function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'managerEmail' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lead = Lead::create([
            'managerEmail' => $request->managerEmail,
            'managerFullName' => $request->managerFullName,
            'managerGender' => $request->managerGender,
            'managerPhone' => $request->managerPhone,
            'companyName' => $request->companyName,
            'activity' => $request->activity,
            'address' => $request->address,
            'capital' => $request->capital,
            'structure' => $request->structure,
            'accountant' => $request->accountant === true ? 'yes' : 'no',
            'nonPartnerManager' => $request->nonPartnerManager === true ? 'yes' : 'no',
            'delay_creation' => $request->delai_creation,
            'needs' =>  implode(', ', $request->needs),
        ]);

        return response()->json(['success' => 'all good', 'lead' => $lead] , 200);

    }
}
