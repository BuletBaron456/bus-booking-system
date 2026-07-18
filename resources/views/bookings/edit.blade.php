@extends('layouts.app')

@section('title', 'Manage Booking')

@section('content')
<h2 class="mb-4">Manage Booking</h2>

<div class="booking-form">
    <p><strong>Passenger:</strong> {{ $booking->passenger_name }}</p>
    <p><strong>Contact:</strong> {{ $booking->contact_number }}</p>
    <p><strong>Seat:</strong> {{ $booking->seat_number }}</p>

    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Booking Status</label>
                <select name="booking_status" class="form-select" required>
                    <option value="pending" @selected($booking->booking_status === 'pending')>Pending</option>
                    <option value="confirmed" @selected($booking->booking_status === 'confirmed')>Confirmed</option>
                    <option value="cancelled" @selected($booking->booking_status === 'cancelled')>Cancelled</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Payment Status</label>
                <select name="payment_status" class="form-select" required>
                    <option value="unpaid" @selected($booking->payment_status === 'unpaid')>Unpaid</option>
                    <option value="paid" @selected($booking->payment_status === 'paid')>Paid</option>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-confirm">Update Booking</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection