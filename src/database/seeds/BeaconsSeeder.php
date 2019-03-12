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
        $beacons = [
            [1, 'E9:DC:0E:20:E3:DC', 1],
            [2, 'D2:7E:91:02:AB:64', 1],
            [3, 'F3:86:35:4C:6E:03', 1],
            [4, 'EA:93:BA:E7:99:82', 2],
            [5, 'C0:DA:B3:09:A9:FB', 2],
            [6, 'F6:A3:B4:E1:D1:15', 3],
            [7, 'CA:18:A2:88:34:DE', 3],
            [8, 'FA:86:25:BE:3C:21', 4],
            [9, 'F3:8F:DE:2F:66:C9', 5],
        ];

        foreach ($beacons as $item) {
            $beacon = factory(App\Beacon::class)->make();
            $beacon->id = $item[0];
            $beacon->bssid = $item[1];
            $beacon->location_id = $item[2];
            $beacon->save();
        }
    }
}
