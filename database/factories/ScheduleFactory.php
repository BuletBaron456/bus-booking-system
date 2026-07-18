<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    public function definition(): array
    {
        $departureTime = $this->faker->time('H:i:s');

        return [
            'bus_id' => Bus::inRandomOrder()->first()?->id ?? Bus::factory(),
            'route_id' => Route::inRandomOrder()->first()?->id ?? Route::factory(),
            'departure_date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'departure_time' => $departureTime,
            'arrival_time' => date('H:i:s', strtotime($departureTime) + rand(4, 10) * 3600),
            'price' => $this->faker->randomElement([450, 550, 650, 750, 850]),
        ];
    }
}