@extends('layouts.app')

@section('title', 'Manage Routes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Routes</h2>
    <a href="{{ route('admin.routes.create') }}" class="btn btn-book">
        <i class="bi bi-plus-lg"></i> Add Route
    </a>
</div>

<div class="dashboard-card">
    <div class="table-responsive">
        <table class="table table-custom align-middle">
            <thead>
                <tr>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Distance</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($routes as $route)
                    <tr>
                        <td>{{ $route->origin }}</td>
                        <td>{{ $route->destination }}</td>
                        <td>{{ $route->distance }}</td>
                        <td>{{ $route->duration }}</td>
                        <td>
                            <a href="{{ route('admin.routes.edit', $route) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this route?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-cancel">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No routes yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $routes->links() }}
</div>
@endsection