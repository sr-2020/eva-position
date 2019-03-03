<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="NewLocation", required={"label"},
 *     @OA\Property(property="label", format="string", type="string", default="Hall Room", example="Hall Room"),
 * )
 */

/**
 * @OA\Schema(schema="Location", required={"id", "label"},
 *    @OA\Property(property="id", format="int64", type="integer", example=1),
 *    @OA\Property(property="label", format="string", type="string", example="Hall Room")
 * )
 */

class Location extends Model
{
    protected $fillable = [
        'label'
    ];

    protected $visible = [
        'id',
        'label'
    ];

    /**
     * Get users.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the beacons for the location.
     */
    public function beacons()
    {
        return $this->belongsToMany('App\Beacon');
    }
}
