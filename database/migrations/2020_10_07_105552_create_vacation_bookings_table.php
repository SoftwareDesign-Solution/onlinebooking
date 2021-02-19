<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationBookingsTable extends Migration
{

    public function up()
    {
        Schema::create('vacation_bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->dateTime('from');
            $table->dateTime('to');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacation_bookings');
    }
}
