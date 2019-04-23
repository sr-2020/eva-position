<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsBeaconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions_beacons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('position_id');
            $table->integer('beacon_id')->nullable();
            $table->string('bssid');
            $table->integer('level');

            $table->index('position_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions_beacons');
    }
}
