@extends('layouts.app')

@section('title', 'Edit Schedule')

@section('content')
<h2 class="mb-4">Edit Schedule</h2>

<div class="booking-form">
    <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Bus</label>
                <select name="bus_id" class="form-select" required>
                    @foreach($buses as $bus)
                        <option value="{{ $bus->id }}" @selected($schedule->bus_id === $bus->id)>{{ $bus->bus_name }} ({{ $bus->bus_number }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Route</label>
                <select name="route_id" class="form-select" required>
                    @foreach($routes as $route)
                        <option value="{{ $route->id }}" @selected($schedule->route_id === $route->id)>{{ $route->origin }} → {{ $route->destination }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Departure Date</label>
                <input type="date" name="departure_date" class="form-control" value="{{ $schedule->departure_date->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Departure Time</label>
                <input type="time" name="departure_time" class="form-control" value="{{ $schedule->departure_time }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Arrival Time</label>
                <input type="time" name="arrival_time" class="form-control" value="{{ $schedule->arrival_time }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Price (₱)</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ $schedule->price }}" required>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-book">Update Schedule</button>
            <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection