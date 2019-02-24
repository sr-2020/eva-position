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
        $beacon->save();

        $beacon = factory(App\Beacon::class)->make();
        $beacon->bssid = '00:00:00:00:00:0b';
        $beacon->save();
    }
}
