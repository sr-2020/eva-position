<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="NewLocation", required={"label"},
 *     @OA\Property(property="label", format="string", type="string", default="Hall Room", example="Hall Room"),
 *     @OA\Property(property="polygon", format="array", type="object", example="{}",
 *       @OA\Items(
 *          type="array",
 *          example="{}",
 *          @OA\Items()
 *       ),
 *     ),
 *     @OA\Property(property="options", format="array", type="object", example="{}",
 *       @OA\Items(
 *          type="array",
 *          example="{}",
 *          @OA\Items()
 *       ),
 *     ),
 * )
 */

/**
 * @OA\Schema(schema="Location", required={"id", "label"},
 *    @OA\Property(property="id", format="int64", type="integer", example=1),
 *    @OA\Property(property="label", format="string", type="string", example="Hall Room"),
 *     @OA\Property(property="polygon", format="array", type="object", example="{}",
 *       @OA\Items(
 *          type="array",
 *          example="{}",
 *          @OA\Items()
 *       ),
 *     ),
 *     @OA\Property(property="options", format="array", type="object", example="{}",
 *       @OA\Items(
 *          type="array",
 *          example="{}",
 *          @OA\Items()
 *       ),
 *     ),
 *     @OA\Property(property="beacons", format="array", type="array", nullable=true,
 *         @OA\Items(ref="#/components/schemas/Beacon")
 *     ),
 * )
 */

class Location extends Model
{
    protected $casts = [
        'polygon' => 'object',
        'options' => 'object'
    ];

    protected $fillable = [
        'label',
        'polygon',
        'options',
    ];

    protected $visible = [
        'id',
        'label',
        'polygon',
        'options',
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
        return $this->hasMany('App\Beacon');
    }
}
