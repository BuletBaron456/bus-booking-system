@extends('layouts.app')

@section('title', 'My Tickets')

@section('content')
<h2 class="mb-4">{{ auth()->user()->isAdmin() ? 'All Bookings' : 'My Tickets' }}</h2>

<div class="dashboard-card">
    <div class="table-responsive">
        <table class="table table-custom align-middle">
            <thead>
                <tr>
                    @if(auth()->user()->isAdmin())
                        <th>Passenger</th>
                    @endif
                    <th>Route</th>
                    <th>Bus</th>
                    <th>Date</th>
                    <th>Seat</th>
                    <th>Booking Status</th>
                    <th>Payment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        @if(auth()->user()->isAdmin())
                            <td>{{ $booking->passenger_name }}</td>
                        @endif
                        <td>{{ $booking->schedule->route->origin }} → {{ $booking->schedule->route->destination }}</td>
                        <td>{{ $booking->schedule->bus->bus_name }}</td>
                        <td>{{ $booking->schedule->departure_date->format('M d, Y') }}</td>
                        <td>{{ $booking->seat_number }}</td>
                        <td><span class="badge-status badge-{{ $booking->booking_status }}">{{ ucfirst($booking->booking_status) }}</span></td>
                        <td><span class="badge-status badge-{{ $booking->payment_status }}">{{ ucfirst($booking->payment_status) }}</span></td>
                        <td>
                            <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">View</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-outline-secondary">Manage</a>
                            @elseif($booking->booking_status === 'pending')
                                <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-cancel">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $bookings->links() }}
</div>
@endsection