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
        App\Beacon::insert([
            ['bssid' => 'E9:DC:0E:20:E3:DC', 'ssid' => 'E9:DC:0E:20:E3:DC', 'location_id' => 1],
            ['bssid' => 'D2:7E:91:02:AB:64', 'ssid' => 'D2:7E:91:02:AB:64', 'location_id' => 1],
            ['bssid' => 'F3:86:35:4C:6E:03', 'ssid' => 'F3:86:35:4C:6E:03', 'location_id' => 1],
            ['bssid' => 'C0:DA:B3:09:A9:FB', 'ssid' => 'C0:DA:B3:09:A9:FB', 'location_id' => 2],
            ['bssid' => 'F6:A3:B4:E1:D1:15', 'ssid' => 'F6:A3:B4:E1:D1:15', 'location_id' => 2],
            ['bssid' => 'F3:8F:DE:2F:66:C9', 'ssid' => 'F3:8F:DE:2F:66:C9', 'location_id' => 3],
        ]);
    }
}
