<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
            'name' => "Proberaum " . $this->faker->randomDigitNotNull,
            'genre' => $this->faker->word,
            'rate' => $this->faker->numberBetween(10, 30),
            'smoking' => $this->faker->boolean,
            'air_conditioned' => $this->faker->boolean,
            'active' => $this->faker->boolean,
            'equipment' => $this->faker->text,
            'description' => $this->faker->text
        ];
    }
}
