<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // filtered per-user or admin in controller query
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->isAdmin() || $user->id === $booking->user_id;
    }

    public function create(User $user): bool
    {
        return true; // any logged-in user can create a booking
    }

    public function update(User $user, Booking $booking): bool
    {
        // Admin can update any booking (e.g. approve/change status)
        return $user->isAdmin();
    }

    public function delete(User $user, Booking $booking): bool
    {
        // Users can cancel their own pending bookings; admin can cancel any
        return $user->isAdmin()
            || ($user->id === $booking->user_id && $booking->booking_status === 'pending');
    }
}