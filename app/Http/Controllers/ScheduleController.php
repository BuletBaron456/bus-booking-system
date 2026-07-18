<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['bus', 'route']);

        if ($request->filled('date')) {
            $query->whereDate('departure_date', $request->date);
        }

        if ($request->filled('origin')) {
            $query->whereHas('route', fn ($q) => $q->where('origin', 'like', "%{$request->origin}%"));
        }

        if ($request->filled('destination')) {
            $query->whereHas('route', fn ($q) => $q->where('destination', 'like', "%{$request->destination}%"));
        }

        $schedules = $query->orderBy('departure_date')->paginate(10)->withQueryString();

        return view('schedules.index', compact('schedules'));
    }

    public function calendarEvents()
    {
        $schedules = Schedule::with(['bus', 'route'])->get();

        $events = $schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => $schedule->route->origin . ' → ' . $schedule->route->destination,
                'start' => $schedule->departure_date->format('Y-m-d'),
                'extendedProps' => [
                    'bus' => $schedule->bus->bus_name,
                    'bus_number' => $schedule->bus->bus_number,
                    'departure_time' => $schedule->departure_time,
                    'arrival_time' => $schedule->arrival_time,
                    'price' => $schedule->price,
                    'available_seats' => count($schedule->availableSeats()),
                ],
            ];
        });

        return response()->json($events);
    }

    public function create()
    {
        $buses = Bus::where('status', 'active')->get();
        $routes = Route::all();
        return view('schedules.create', compact('buses', 'routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load(['bus', 'route']);
        $bookedSeats = $schedule->bookedSeats();

        return view('schedules.show', compact('schedule', 'bookedSeats'));
    }

    public function edit(Schedule $schedule)
    {
        $buses = Bus::where('status', 'active')->get();
        $routes = Route::all();
        return view('schedules.edit', compact('schedule', 'buses', 'routes'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}