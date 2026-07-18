<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'route_id',
        'departure_date',
        'departure_time',
        'arrival_time',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'departure_date' => 'date',
            'price' => 'decimal:2',
        ];
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Helper: get seat numbers already booked (excluding cancelled)
    public function bookedSeats()
    {
        return $this->bookings()
            ->where('booking_status', '!=', 'cancelled')
            ->pluck('seat_number')
            ->toArray();
    }

    // Helper: get list of all available seats
    public function availableSeats()
    {
        $allSeats = range(1, $this->bus->total_seats);
        $booked = $this->bookedSeats();

        return array_values(array_diff($allSeats, $booked));
    }
}