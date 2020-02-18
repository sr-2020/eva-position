<?php

namespace App;

/**
 * @OA\Schema(schema="NewPosition", required={"name"},
 *     @OA\Property(property="beacons", format="array", type="array",
 *         @OA\Items(ref="#/components/schemas/BeaconSignal")
 *     )
 * )
 */

/**
 * @OA\Schema(schema="Position", type="object", required={"id", "user_id"},
 *    @OA\Property(property="id", format="int64", type="integer", example=1),
 *    @OA\Property(property="user_id", format="int64", type="integer", example=1),
 *    @OA\Property(property="created_at", format="string", type="string", example="2019-01-26 20:00:57"),
 *    @OA\Property(property="beacons", format="array", type="array", nullable=true,
 *        @OA\Items(ref="#/components/schemas/BeaconSignal")
 *    ),
 *    @OA\Property(property="lat", format="float", type="number", nullable=true, default=null, example=50.5),
 *    @OA\Property(property="lng", format="float", type="number", nullable=true, default=null, example=-70.7),
 *    @OA\Property(property="type", format="int64", type="integer", nullable=true, example=1),
 * )
 */

class Position extends Model
{
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'beacons' => 'array',
        'type' => 'int',
        'lat' => 'float',
        'lng' => 'float',
    ];

    protected $fillable = [
        'beacons',
        'type',
        'lat',
        'lng',
    ];

    protected $visible = [
        'id',
        'user_id',
        'beacons',
        'type',
        'lat',
        'lng',
        'created_at',
        'updated_at'
    ];

    /**
     * @var array
     */
    protected static $rules = [
        'common' => [
            'beacons.*.level' => 'integer|between:-200,0',
        ],
        'create' => [],
        'update' => [
            'id' => 'between:1,1000000000',
        ],
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            if (!is_array($model->beacons)) {
                $model->beacons = [];
            }
        });

        static::created(function($model) {
            if (is_array($model->beacons)) {
                foreach ($model->beacons as $beacon) {
                    $beacon['beacon_id'] = null;
                    $beacon['bssid'] = strtoupper($beacon['bssid']);
                    $beaconModel = Beacon::where('bssid', $beacon['bssid'])->first();
                    if (null !== $beaconModel) {
                        $beacon['beacon_id'] = $beaconModel->id;
                    }

                    $model->beacons()->create($beacon);
                }
            }
        });
    }

    /**
     * Get the beacons for the position.
     */
    public function beacons()
    {
        return $this->hasMany('App\PositionBeacon');
    }
}
