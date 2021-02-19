<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'room_id' => Room::factory(),
            'from' => $this->faker->dateTime,
            'to' => $this->faker->dateTime
        ];
    }
}
