<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="PositionBeacon", type="object", required={"id", "position_id"},
 *    @OA\Property(property="id", format="int64", type="integer", example=1),
 *    @OA\Property(property="position_id", format="int64", type="integer", example=1),
 *    @OA\Property(property="beacon_id", format="int64", type="integer", example=1),
 *    @OA\Property(property="bssid", format="string", type="string", example="b0:0a:95:9d:00:0a"),
 *    @OA\Property(property="level", format="int64", type="integer", example=-50)
 * )
 */

class PositionBeacon extends Model
{
    protected $table = 'positions_beacons';

    public $timestamps = false;

    protected $fillable = [
        'position_id',
        'beacon_id',
        'bssid',
        'level'
    ];

    protected $visible = [
        'id',
        'position_id',
        'beacon_id',
        'bssid',
        'level'
    ];
}
