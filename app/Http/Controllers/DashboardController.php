<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $totalTickets = Booking::where('user_id', $user->id)->count();

        $upcomingTrips = Booking::where('user_id', $user->id)
            ->where('booking_status', '!=', 'cancelled')
            ->whereHas('schedule', fn ($q) => $q->where('departure_date', '>=', now()->toDateString()))
            ->count();

        $totalBuses = Bus::where('status', 'active')->count();

        $recentBookings = Booking::with(['schedule.bus', 'schedule.route'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalTickets',
            'upcomingTrips',
            'totalBuses',
            'recentBookings'
        ));
    }
}