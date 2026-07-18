<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use App\Notifications\BookingConfirmed;
use Illuminate\Http\Request;

class BookingApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $bookings = $user->isAdmin()
            ? Booking::with(['user', 'schedule.bus', 'schedule.route'])->get()
            : Booking::with(['schedule.bus', 'schedule.route'])->where('user_id', $user->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Bookings retrieved successfully',
            'data' => $bookings,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seat_number' => 'required|string',
            'passenger_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);

        $alreadyTaken = Booking::where('schedule_id', $schedule->id)
            ->where('seat_number', $validated['seat_number'])
            ->where('booking_status', '!=', 'cancelled')
            ->exists();

        if ($alreadyTaken) {
            return response()->json([
                'success' => false,
                'message' => 'This seat is already booked.',
                'data' => [],
            ], 422);
        }

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'schedule_id' => $validated['schedule_id'],
            'seat_number' => $validated['seat_number'],
            'passenger_name' => $validated['passenger_name'],
            'contact_number' => $validated['contact_number'],
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $request->user()->notify(new BookingConfirmed($booking));

        return response()->json([
            'success' => true,
            'message' => 'Ticket booked successfully',
            'data' => $booking->load(['schedule.bus', 'schedule.route']),
        ], 201);
    }

    public function show(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking);

        return response()->json([
            'success' => true,
            'message' => 'Booking retrieved successfully',
            'data' => $booking->load(['schedule.bus', 'schedule.route']),
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'booking_status' => 'sometimes|in:pending,confirmed,cancelled',
            'payment_status' => 'sometimes|in:unpaid,paid',
        ]);

        $booking->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => $booking,
        ]);
    }

    public function destroy(Request $request, Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->update(['booking_status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Booking cancelled successfully',
            'data' => [],
        ]);
    }
}