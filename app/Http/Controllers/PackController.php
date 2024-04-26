<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\Http\Request;

class PackController extends Controller
{
    function index() {
        $packs = Pack::with('packFeatures')->get();

        return response()->json($packs);
    }
}
