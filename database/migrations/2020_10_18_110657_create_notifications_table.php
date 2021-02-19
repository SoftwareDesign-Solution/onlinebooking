<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{

    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('type');
            $table->text('content')->nullable();
            $table->timestamp('last_displayed')->nullable();
            $table->bigInteger('user_id')->unsigned();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }

}
