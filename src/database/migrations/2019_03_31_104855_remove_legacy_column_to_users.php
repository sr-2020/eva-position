<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveLegacyColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('beacon_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('amount');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->default('test')->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('amount')->default(0);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('beacon_id')->nullable();
        });
    }
}
