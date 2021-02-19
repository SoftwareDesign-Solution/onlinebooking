<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CascadeUserDeletion extends Migration
{

    public function up()
    {
        if (env('DB_CONNECTION') == 'sqlite') {
            // SQLite does not support dropping foreign keys
            return;
        }

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    public function down()
    {
        if (env('DB_CONNECTION') == 'sqlite') {
            // SQLite does not support dropping foreign keys
            return;
        }

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
