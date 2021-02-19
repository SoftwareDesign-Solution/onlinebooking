<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImproveRoomImageTable extends Migration
{

    public function up()
    {
        Schema::table('room_images', function (Blueprint $table) {
            $table->dropColumn('id');

            $table->primary(['filename', 'room_id']);
        });

    }


    public function down()
    {
        Schema::table('room_images', function (Blueprint $table) {
            $table->dropPrimary();
        });

        Schema::table('room_images', function (Blueprint $table) {
            $table->bigIncrements('id');
        });
    }
}
