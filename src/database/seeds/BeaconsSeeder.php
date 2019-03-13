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
            [10,'EE:D2:A8:E2:1C:62', 5],
            [11,'FE:B1:7B:B6:2B:4A', 5],
            [12,'FE:7B:B7:53:58:CB', 5],
            [13,'CE:1B:0B:7F:5A:78', 5],
            [14,'DD:C3:4A:60:04:B2', 5],
            [15,'D2:28:CC:D7:E7:25', 5],
            [16,'C1:22:25:79:BF:01', 5],
            [17,'D8:BE:39:1F:C1:B9', 5],
            [18,'FE:89:92:CF:68:DC', 5],
            [19,'C8:16:32:73:E6:12', 5],
            [20,'D7:FC:39:B0:C3:3F', 5],
            [21,'F2:89:3D:99:E4:ED', 5],
            [22,'EF:CF:7F:3D:AC:BE', 5],
            [23,'F5:3F:62:31:D5:77', 5],
            [24,'EA:0A:9D:97:5C:0B', 5],
            [25,'F2:D0:8F:FB:03:13', 5],
            [26,'FC:07:F4:BD:CE:99', 5],
            [27,'D4:D4:99:45:85:62', 5],
            [28,'C7:50:4F:33:F8:A8', 5],
            [29,'D4:CA:FF:13:EC:66', 5],
            [30,'F9:D8:BB:48:39:85', 5],
            [31,'C5:B8:18:6D:92:6C', 5],
            [32,'F1:20:B3:13:21:10', 5],
            [33,'E5:D4:15:A0:D7:53', 5],
            [34,'DF:8C:6D:50:E0:16', 5],
            [35,'EB:A9:56:03:77:B0', 5],
            [36,'E9:FD:82:B3:F6:32', 5],
            [37,'E9:69:E1:63:07:52', 5],
            [38,'EA:13:F9:38:56:BA', 5],
            [39,'C3:95:20:82:41:33', 5],
            [40,'FE:7F:61:D0:1E:F1', 5],
            [41,'E4:BA:D7:C6:09:B6', 5],
            [42,'F1:73:DA:77:7F:7A', 5],
            [43,'DE:4E:8A:C7:44:28', 5],
            [44,'DF:64:7F:DE:2C:D1', 5],
            [45,'F4:4B:23:B8:93:33', 5],
        ];

        foreach ($beacons as $item) {
            $beacon = factory(App\Beacon::class)->make();
            $beacon->id = $item[0];
            $beacon->label = '#' . $item[0];
            $beacon->bssid = $item[1];
            $beacon->ssid = $item[1];
            $beacon->location_id = $item[2];
            $beacon->save();
        }
    }
}
