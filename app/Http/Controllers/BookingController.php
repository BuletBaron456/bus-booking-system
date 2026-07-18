<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use App\Notifications\BookingConfirmed;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $bookings = $user->isAdmin()
            ? Booking::with(['user', 'schedule.bus', 'schedule.route'])->latest()->paginate(15)
            : Booking::with(['schedule.bus', 'schedule.route'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);

        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $schedule = Schedule::with(['bus', 'route'])->findOrFail($request->schedule_id);
        $bookedSeats = $schedule->bookedSeats();

        return view('bookings.create', compact('schedule', 'bookedSeats'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Booking::class);

        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seat_number' => 'required|string',
            'passenger_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);

        // Block booking on trips that already departed
        if ($schedule->departure_date->isPast()) {
            return back()->withErrors(['schedule_id' => 'This trip has already departed. Please choose an upcoming schedule.']);
        }

        // prevent double-booking race condition
        $alreadyTaken = Booking::where('schedule_id', $schedule->id)
            ->where('seat_number', $validated['seat_number'])
            ->where('booking_status', '!=', 'cancelled')
            ->exists();

        if ($alreadyTaken) {
            return back()->withErrors(['seat_number' => 'This seat has just been booked by someone else. Please choose another.']);
        }

        try {
            $booking = Booking::create([
                'user_id' => $request->user()->id,
                'schedule_id' => $validated['schedule_id'],
                'seat_number' => $validated['seat_number'],
                'passenger_name' => $validated['passenger_name'],
                'contact_number' => $validated['contact_number'],
                'booking_status' => 'pending',
                'payment_status' => 'unpaid',
            ]);
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()->withErrors(['seat_number' => 'This seat is no longer available. Please choose another seat.']);
        }

        $request->user()->notify(new BookingConfirmed($booking));

        return redirect()->route('bookings.show', $booking)->with('success', 'Ticket booked successfully!');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['schedule.bus', 'schedule.route', 'user']);

        return view('tickets.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);
        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'booking_status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'required|in:unpaid,paid',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->update(['booking_status' => 'cancelled']);

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled.');
    }
}