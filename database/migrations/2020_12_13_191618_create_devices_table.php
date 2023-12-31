<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('ip', 255);
            $table->string('archived')->nullable();
            // $table->unsignedBigInteger('user_id')->comment('Created By User');

            // $table->foreign('user_id')->references('id')->on('users');
            $table->serializeDate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
