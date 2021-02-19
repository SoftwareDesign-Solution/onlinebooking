<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralTable extends Migration
{

    public function up()
    {
        Schema::create('general', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('opening_hours_start_weekdays')->default(0);
            $table->integer('opening_hours_end_weekdays')->default(23);
            $table->integer('opening_hours_start_weekend')->default(0);
            $table->integer('opening_hours_end_weekend')->default(23);
        });
    }

    public function down()
    {
        Schema::dropIfExists('general');
    }

}
