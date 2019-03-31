<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="NewBeacon", required={"bssid"},
 *     @OA\Property(property="label", format="string", type="string", default="Hall Room", example="Hall Room"),
 *     @OA\Property(property="ssid", format="string", type="string", default="hall2", example="hall2"),
 *     @OA\Property(property="bssid", format="string", type="string", default="c0:0a:95:9d:00:0c", example="c0:0a:95:9d:00:0c"),
 * )
 */

/**
 * @OA\Schema(schema="BeaconSignal", required={"ssid", "bssid", "level"},
 *    @OA\Property(property="ssid", format="string", type="string", example="beacon1"),
 *    @OA\Property(property="bssid", format="string", type="string", example="b0:0a:95:9d:00:0a"),
 *    @OA\Property(property="level", format="int64", type="integer", example=-50),
 * )
 */

/**
 * @OA\Schema(schema="Beacon", required={"id", "bssid"},
 *    @OA\Property(property="id", format="int64", type="integer", example=1),
 *    @OA\Property(property="label", format="string", type="string", example="Hall Room"),
 *    @OA\Property(property="ssid", format="string", type="string", example="beacon1"),
 *    @OA\Property(property="bssid", format="string", type="string", example="b0:0a:95:9d:00:0a")
 * )
 */

class Beacon extends Model
{
    protected $fillable = [
        'label',
        'ssid',
        'bssid',
        'location_id'
    ];

    protected $visible = [
        'id',
        'label',
        'ssid',
        'bssid',
        'location_id'
    ];

    /**
     * Get the beacon's label.
     *
     * @param  string  $value
     * @return string
     */
    public function getLabelAttribute($value)
    {
        return (string)$value;
    }

    /**
     * @param string $bssid
     */
    public function setBssidAttribute($bssid)
    {
        $this->attributes['bssid'] = strtoupper($bssid);
    }
}
