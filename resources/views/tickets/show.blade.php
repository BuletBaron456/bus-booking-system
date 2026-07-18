@extends('layouts.app')

@section('title', 'Ticket Details')

@section('content')
<div class="dashboard-card mx-auto" style="max-width: 600px;">
    <div class="text-center mb-4">
        <i class="bi bi-ticket-perforated-fill text-primary" style="font-size: 3rem;"></i>
        <h4 class="mt-2">Bus Ticket</h4>
        <span class="badge-status badge-{{ $booking->booking_status }}">{{ ucfirst($booking->booking_status) }}</span>
    </div>

    <hr>

    <div class="row mb-2">
        <div class="col-6 text-muted">Passenger</div>
        <div class="col-6 text-end">{{ $booking->passenger_name }}</div>
    </div>
    <div class="row mb-2">
        <div class="col-6 text-muted">Contact</div>
        <div class="col-6 text-end">{{ $booking->contact_number }}</div>
    </div>
    <div class="row mb-2">
        <div class="col-6 text-muted">Bus</div>
        <div class="col-6 text-end">{{ $booking->schedule->bus->bus_name }} ({{ $booking->schedule->bus->bus_number }})</div>
    </div>
    <div class="row mb-2">
        <div class="col-6 text-muted">Route</div>
        <div class="col-6 text-end">{{ $booking->schedule->route->origin }} → {{ $booking->schedule->route->destination }}</div>
    </div>
    <div class="row mb-2">
        <div class="col-6 text-muted">Departure</div>
        <div class="col-6 text-end">{{ $booking->schedule->departure_date->format('M d, Y') }} {{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('h:i A') }}</div>
    </div>
    <div class="row mb-2">
        <div class="col-6 text-muted">Seat Number</div>
        <div class="col-6 text-end fw-bold">{{ $booking->seat_number }}</div>
    </div>
    <div class="row mb-2">
        <div class="col-6 text-muted">Payment</div>
        <div class="col-6 text-end"><span class="badge-status badge-{{ $booking->payment_status }}">{{ ucfirst($booking->payment_status) }}</span></div>
    </div>

    <hr>

    <a href="{{ route('bookings.index') }}" class="btn btn-book w-100">Back to My Tickets</a>
</div>
@endsection