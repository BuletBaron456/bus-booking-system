@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4">Welcome back, {{ auth()->user()->name }}</h2>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="dashboard-card d-flex justify-content-between align-items-center">
            <div>
                <p class="text-muted mb-1">Total Tickets</p>
                <div class="stat-number">{{ $totalTickets }}</div>
            </div>
            <i class="bi bi-ticket-perforated stat-icon text-primary"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card d-flex justify-content-between align-items-center">
            <div>
                <p class="text-muted mb-1">Upcoming Trips</p>
                <div class="stat-number">{{ $upcomingTrips }}</div>
            </div>
            <i class="bi bi-calendar-check stat-icon text-success"></i>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-card d-flex justify-content-between align-items-center">
            <div>
                <p class="text-muted mb-1">Available Buses</p>
                <div class="stat-number">{{ $totalBuses }}</div>
            </div>
            <i class="bi bi-bus-front stat-icon text-warning"></i>
        </div>
    </div>
</div>

<div class="dashboard-card">
    <h5 class="mb-3">Recent Bookings</h5>
    <div class="table-responsive">
        <table class="table table-custom align-middle">
            <thead>
                <tr>
                    <th>Route</th>
                    <th>Bus</th>
                    <th>Departure</th>
                    <th>Seat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->schedule->route->origin }} → {{ $booking->schedule->route->destination }}</td>
                        <td>{{ $booking->schedule->bus->bus_name }}</td>
                        <td>{{ $booking->schedule->departure_date->format('M d, Y') }}</td>
                        <td>{{ $booking->seat_number }}</td>
                        <td><span class="badge-status badge-{{ $booking->booking_status }}">{{ ucfirst($booking->booking_status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No bookings yet. <a href="{{ route('schedules.index') }}">Book a trip now</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection