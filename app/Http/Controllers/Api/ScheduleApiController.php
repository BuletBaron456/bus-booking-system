<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Schedules retrieved successfully',
            'data' => Schedule::with(['bus', 'route'])->get(),
        ]);
    }
}