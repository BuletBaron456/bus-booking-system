<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    public function definition(): array
    {
        $cities = [
            ['Dagupan City', 'Manila', '5 hours'],
            ['Baguio City', 'Manila', '6 hours'],
            ['Manila', 'Vigan City', '8 hours'],
            ['Manila', 'Baguio City', '6 hours'],
            ['Manila', 'Dagupan City', '5 hours'],
            ['Cubao', 'Laoag City', '10 hours'],
        ];

        [$origin, $destination, $duration] = $this->faker->randomElement($cities);

        return [
            'origin' => $origin,
            'destination' => $destination,
            'distance' => $this->faker->numberBetween(150, 450) . ' km',
            'duration' => $duration,
        ];
    }
}