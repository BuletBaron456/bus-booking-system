@extends('layouts.app')

@section('title', 'Manage Buses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Buses</h2>
    <a href="{{ route('admin.buses.create') }}" class="btn btn-book">
        <i class="bi bi-plus-lg"></i> Add Bus
    </a>
</div>

<div class="dashboard-card">
    <div class="table-responsive">
        <table class="table table-custom align-middle">
            <thead>
                <tr>
                    <th>Bus Number</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Total Seats</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buses as $bus)
                    <tr>
                        <td>{{ $bus->bus_number }}</td>
                        <td>{{ $bus->bus_name }}</td>
                        <td>{{ $bus->bus_type }}</td>
                        <td>{{ $bus->total_seats }}</td>
                        <td>
                            <span class="badge-status {{ $bus->status === 'active' ? 'badge-confirmed' : 'badge-cancelled' }}">
                                {{ ucfirst($bus->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.buses.edit', $bus) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.buses.destroy', $bus) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this bus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-cancel">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No buses yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $buses->links() }}
</div>
@endsection