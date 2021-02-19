<?php

namespace Database\Factories;

use App\Models\SpecialBooking;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacationBookingFactory extends Factory
{
    protected $model = SpecialBooking::class;

    public function definition()
    {
        return [
            'from' => $this->faker->dateTime,
            'to' => $this->faker->dateTime
        ];
    }
}
