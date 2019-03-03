<?php

use Illuminate\Database\Seeder;

class BeaconsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $beacon = factory(App\Beacon::class)->make();
        $beacon->bssid = '00:00:00:00:00:0a';
        $beacon->location_id = 1;
        $beacon->save();

        $beacon = factory(App\Beacon::class)->make();
        $beacon->bssid = '00:00:00:00:00:0b';
        $beacon->location_id = 2;
        $beacon->save();

        $beacon = factory(App\Beacon::class)->make();
        $beacon->bssid = '00:00:00:00:00:0c';
        $beacon->location_id = 2;
        $beacon->save();

        $beacon = factory(App\Beacon::class)->make();
        $beacon->bssid = '00:00:00:00:00:0d';
        $beacon->save();
    }
}
