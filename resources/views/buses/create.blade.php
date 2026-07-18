@extends('layouts.app')

@section('title', 'Add Bus')

@section('content')
<h2 class="mb-4">Add New Bus</h2>

<div class="booking-form">
    <form action="{{ route('admin.buses.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Bus Number</label>
                <input type="text" name="bus_number" class="form-control" value="{{ old('bus_number') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Bus Name</label>
                <input type="text" name="bus_name" class="form-control" value="{{ old('bus_name') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Bus Type</label>
                <input type="text" name="bus_type" class="form-control" value="{{ old('bus_type') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Total Seats</label>
                <input type="number" name="total_seats" class="form-control" value="{{ old('total_seats', 45) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-book">Save Bus</button>
            <a href="{{ route('admin.buses.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection