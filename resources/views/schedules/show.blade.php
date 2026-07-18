@extends('layouts.app')

@section('title', 'Trip Details')

@section('content')
<div class="dashboard-card mb-4">
    <h4>{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</h4>
    <p class="text-muted mb-1"><strong>Bus:</strong> {{ $schedule->bus->bus_name }} ({{ $schedule->bus->bus_number }})</p>
    <p class="text-muted mb-1"><strong>Date:</strong> {{ $schedule->departure_date->format('F d, Y') }}</p>
    <p class="text-muted mb-1"><strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->arrival_time)->format('h:i A') }}</p>
    <p class="bus-card-price">₱{{ number_format($schedule->price, 2) }}</p>
</div>

<div class="dashboard-card mb-4">
    <h5 class="mb-3">Select Your Seat</h5>
    <div class="seat-map" id="seatMap">
        @for($i = 1; $i <= $schedule->bus->total_seats; $i++)
            <div class="seat {{ in_array((string) $i, $bookedSeats) ? 'reserved' : 'available' }}" data-seat="{{ $i }}">
                {{ $i }}
            </div>
        @endfor
    </div>
    <div class="d-flex gap-3 justify-content-center mt-3">
        <span><span class="seat available d-inline-block" style="width:20px;height:20px;padding:0;"></span> Available</span>
        <span><span class="seat selected d-inline-block" style="width:20px;height:20px;padding:0;"></span> Selected</span>
        <span><span class="seat reserved d-inline-block" style="width:20px;height:20px;padding:0;"></span> Reserved</span>
    </div>
</div>

<div class="booking-form">
    <h5 class="mb-3">Passenger Information</h5>
    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
        <input type="hidden" name="seat_number" id="selectedSeatInput" required>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Passenger Name</label>
                <input type="text" name="passenger_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" placeholder="09XXXXXXXXX" required>
            </div>
        </div>

        <p class="mt-3">Selected seat: <strong id="selectedSeatLabel">None</strong></p>

        <button type="submit" class="btn btn-confirm mt-3" id="submitBtn" disabled>Confirm Booking</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let selectedSeat = null;
    const seats = document.querySelectorAll('.seat.available');
    const input = document.getElementById('selectedSeatInput');
    const label = document.getElementById('selectedSeatLabel');
    const submitBtn = document.getElementById('submitBtn');

    seats.forEach(seat => {
        seat.addEventListener('click', function () {
            seats.forEach(s => s.classList.remove('selected'));
            this.classList.add('selected');
            selectedSeat = this.dataset.seat;
            input.value = selectedSeat;
            label.textContent = 'Seat ' + selectedSeat;
            submitBtn.disabled = false;
        });
    });
});
</script>
@endpush