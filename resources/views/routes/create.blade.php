@extends('layouts.app')

@section('title', 'Add Route')

@section('content')
<h2 class="mb-4">Add New Route</h2>

<div class="booking-form">
    <form action="{{ route('admin.routes.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Origin</label>
                <input type="text" name="origin" class="form-control" value="{{ old('origin') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Destination</label>
                <input type="text" name="destination" class="form-control" value="{{ old('destination') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Distance</label>
                <input type="text" name="distance" class="form-control" value="{{ old('distance') }}" placeholder="e.g. 250 km">
            </div>
            <div class="col-md-6">
                <label class="form-label">Duration</label>
                <input type="text" name="duration" class="form-control" value="{{ old('duration') }}" placeholder="e.g. 5 hours">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-book">Save Route</button>
            <a href="{{ route('admin.routes.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection