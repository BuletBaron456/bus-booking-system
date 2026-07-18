<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BusFactory extends Factory
{
    public function definition(): array
    {
        $types = ['Standard', 'Deluxe', 'Executive', 'Air-Conditioned'];

        return [
            'bus_number' => 'BUS-' . $this->faker->unique()->numberBetween(100, 999),
            'bus_name' => $this->faker->randomElement($types) . ' Bus',
            'bus_type' => $this->faker->randomElement($types),
            'total_seats' => $this->faker->randomElement([30, 40, 45, 50]),
            'status' => 'active',
        ];
    }
}