<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBssidUniqToBeacons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beacons', function (Blueprint $table) {
            $table->unique('bssid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beacons', function (Blueprint $table) {
            $table->dropUnique('beacons_bssid_unique');
        });
    }
}
