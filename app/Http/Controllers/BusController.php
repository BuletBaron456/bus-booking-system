<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::latest()->paginate(10);
        return view('buses.index', compact('buses'));
    }

    public function create()
    {
        return view('buses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_number' => 'required|string|unique:buses,bus_number',
            'bus_name' => 'required|string|max:255',
            'bus_type' => 'required|string|max:255',
            'total_seats' => 'required|integer|min:1|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        Bus::create($validated);

        return redirect()->route('admin.buses.index')->with('success', 'Bus added successfully.');
    }

    public function show(Bus $bus)
    {
        return view('buses.show', compact('bus'));
    }

    public function edit(Bus $bus)
    {
        return view('buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            'bus_number' => 'required|string|unique:buses,bus_number,' . $bus->id,
            'bus_name' => 'required|string|max:255',
            'bus_type' => 'required|string|max:255',
            'total_seats' => 'required|integer|min:1|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $bus->update($validated);

        return redirect()->route('admin.buses.index')->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        return redirect()->route('admin.buses.index')->with('success', 'Bus deleted successfully.');
    }
}