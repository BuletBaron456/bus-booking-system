<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'schedule_id' => Schedule::inRandomOrder()->first()?->id ?? Schedule::factory(),
            'seat_number' => (string) $this->faker->numberBetween(1, 45),
            'passenger_name' => $this->faker->name(),
            'contact_number' => $this->faker->numerify('09#########'),
            'booking_status' => $this->faker->randomElement(['pending', 'confirmed']),
            'payment_status' => $this->faker->randomElement(['unpaid', 'paid']),
        ];
    }
}