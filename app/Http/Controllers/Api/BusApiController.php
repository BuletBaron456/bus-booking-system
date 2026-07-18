<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bus;

class BusApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Buses retrieved successfully',
            'data' => Bus::where('status', 'active')->get(),
        ]);
    }
}