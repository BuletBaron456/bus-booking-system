<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Route;

class RouteApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Routes retrieved successfully',
            'data' => Route::all(),
        ]);
    }
}