@extends('layouts.app')

@section('title', 'Add Schedule')

@section('content')
<h2 class="mb-4">Add New Schedule</h2>

<div class="booking-form">
    <form action="{{ route('admin.schedules.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Bus</label>
                <select name="bus_id" class="form-select" required>
                    <option value="">Select Bus</option>
                    @foreach($buses as $bus)
                        <option value="{{ $bus->id }}">{{ $bus->bus_name }} ({{ $bus->bus_number }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Route</label>
                <select name="route_id" class="form-select" required>
                    <option value="">Select Route</option>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}">{{ $route->origin }} → {{ $route->destination }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Departure Date</label>
                <input type="date" name="departure_date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Departure Time</label>
                <input type="time" name="departure_time" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Arrival Time</label>
                <input type="time" name="arrival_time" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Price (₱)</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-book">Save Schedule</button>
            <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection