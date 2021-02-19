<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialBookingsTable extends Migration
{

    public function up()
    {
        Schema::create('special_bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('notes')->nullable();

            $table->dateTime('from');
            $table->dateTime('to');
            $table->bigInteger('room_id')->unsigned();
        });

        Schema::table('special_bookings', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    public function down()
    {
        Schema::dropIfExists('special_bookings');
    }
}
