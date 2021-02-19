<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsAndRoomsTable extends Migration
{

    private static $TABLE_ROOMS = 'rooms';
    private static $TABLE_ROOM_IMAGES = 'room_images';
    private static $TABLE_BOOKINGS = 'bookings';

    public function up()
    {
        $this->createRoomsTable();
        $this->createRoomImagesTable();
        $this->createBookingsTable();
    }

    private function createRoomsTable() {
        Schema::create(self::$TABLE_ROOMS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('name')->nullable();
            $table->string('genre')->nullable();
            $table->double('rate')->nullable();
            $table->boolean('smoking')->default(false);
            $table->boolean('air_conditioned')->default(false);
            $table->boolean('active')->default(false);
            $table->longText('equipment')->nullable();
            $table->longText('description')->nullable();
        });
    }

    private function createBookingsTable() {
        Schema::create(self::$TABLE_BOOKINGS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->dateTime('from');
            $table->dateTime('to');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('room_id')->unsigned();
        });

        Schema::table(self::$TABLE_BOOKINGS, function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on(self::$TABLE_ROOMS);
        });
    }

    private function createRoomImagesTable(): void
    {
        Schema::create(self::$TABLE_ROOM_IMAGES, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->string('filename');
            $table->bigInteger('room_id')->unsigned();
        });

        Schema::table(self::$TABLE_ROOM_IMAGES, function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on(self::$TABLE_ROOMS);
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::$TABLE_BOOKINGS);
        Schema::dropIfExists(self::$TABLE_ROOM_IMAGES);
        Schema::dropIfExists(self::$TABLE_ROOMS);
    }

}
