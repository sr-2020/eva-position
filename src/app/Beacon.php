<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="NewBeacon", required={"name"},
 *     @OA\Property(property="label", format="string", type="string", example="Hall Room"),
 *     @OA\Property(property="ssid", format="string", type="string"),
 *     @OA\Property(property="bssid", format="string", type="string"),
 * )
 */

/**
 * @OA\Schema(schema="BeaconSignal", required={"ssid", "bbsid", "level"},
 *    @OA\Property(property="ssid", format="string", type="string", example="beacon1"),
 *    @OA\Property(property="bssid", format="string", type="string", example="b0:0a:95:9d:00:0a"),
 *    @OA\Property(property="level", format="int64", type="integer", example=-50),
 * )
 */

/**
 * @OA\Schema(schema="Beacon", required={"ssid", "bbsid", "level"},
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
    ];

    protected $visible = [
        'id',
        'label',
        'ssid',
        'bssid',
    ];

    /**
     * Get users.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
