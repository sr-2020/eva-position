<?php

use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = factory(App\Location::class)->make();
        $location->label = 'Room #1';
        $location->save();

        $location = factory(App\Location::class)->make();
        $location->label = 'Room #2';
        $location->save();

        $location = factory(App\Location::class)->make();
        $location->label = 'Room #3';
        $location->save();
    }
}
