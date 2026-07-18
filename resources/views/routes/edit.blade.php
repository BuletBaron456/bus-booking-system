@extends('layouts.app')

@section('title', 'Edit Route')

@section('content')
<h2 class="mb-4">Edit Route</h2>

<div class="booking-form">
    <form action="{{ route('admin.routes.update', $route) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Origin</label>
                <input type="text" name="origin" class="form-control" value="{{ old('origin', $route->origin) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Destination</label>
                <input type="text" name="destination" class="form-control" value="{{ old('destination', $route->destination) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Distance</label>
                <input type="text" name="distance" class="form-control" value="{{ old('distance', $route->distance) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Duration</label>
                <input type="text" name="duration" class="form-control" value="{{ old('duration', $route->duration) }}">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-book">Update Route</button>
            <a href="{{ route('admin.routes.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection