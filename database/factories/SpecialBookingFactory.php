<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\SpecialBooking;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialBookingFactory extends Factory
{
    protected $model = SpecialBooking::class;

    public function definition()
    {
        return [
            'room_id' => Room::factory(),
            'from' => $this->faker->dateTime,
            'to' => $this->faker->dateTime,
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber
        ];
    }
}
