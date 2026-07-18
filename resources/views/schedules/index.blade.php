@extends('layouts.app')

@section('title', 'Search Bus Schedules')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
@endpush

@section('content')
<h2 class="mb-4">Search Bus Schedules</h2>

<div class="dashboard-card mb-4">
    <div id="calendar"></div>
</div>

<div id="schedule-details" class="dashboard-card mb-4" style="display:none;">
    <h5>Trip Details</h5>
    <div id="schedule-details-body"></div>
</div>

<div class="dashboard-card">
    <h5 class="mb-3">All Available Trips</h5>
    <div class="row g-3">
        @forelse($schedules as $schedule)
            <div class="col-md-6 col-lg-4">
                <div class="bus-card">
                    <div class="bus-card-image">
                        <i class="bi bi-bus-front-fill"></i>
                    </div>
                    <div class="p-3">
                        <h6>{{ $schedule->bus->bus_name }} ({{ $schedule->bus->bus_number }})</h6>
                        <p class="mb-1 text-muted">
                            <i class="bi bi-geo-alt"></i> {{ $schedule->route->origin }} → {{ $schedule->route->destination }}
                        </p>
                        <p class="mb-1 text-muted">
                            <i class="bi bi-calendar3"></i> {{ $schedule->departure_date->format('M d, Y') }}
                            &nbsp;<i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}
                        </p>
                        <p class="bus-card-price mb-2">₱{{ number_format($schedule->price, 2) }}</p>
                        <a href="{{ route('schedules.show', $schedule) }}" class="btn btn-book w-100">View & Book</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No schedules found.</p>
        @endforelse
    </div>
    {{ $schedules->links() }}
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 'auto',
        events: '{{ route("schedules.calendar-events") }}',
        eventClick: function (info) {
            const props = info.event.extendedProps;
            document.getElementById('schedule-details').style.display = 'block';
            document.getElementById('schedule-details-body').innerHTML = `
                <p><strong>Bus:</strong> ${props.bus} (${props.bus_number})</p>
                <p><strong>Route:</strong> ${info.event.title}</p>
                <p><strong>Departure:</strong> ${props.departure_time}</p>
                <p><strong>Arrival:</strong> ${props.arrival_time}</p>
                <p><strong>Price:</strong> ₱${props.price}</p>
                <p><strong>Available Seats:</strong> ${props.available_seats}</p>
                <a href="/schedules/${info.event.id}" class="btn btn-book">View & Book</a>
            `;
            document.getElementById('schedule-details').scrollIntoView({ behavior: 'smooth' });
        }
    });
    calendar.render();
});
</script>
@endpush