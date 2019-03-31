<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Schema(schema="NewPath", required={"user_id"},
 *     @OA\Property(property="user_id", format="int64", type="integer", default=1, example=1),
 *     @OA\Property(property="location_id", format="int64", type="integer", default=1, example=1),
 * )
 */

/**
 * @OA\Schema(schema="Path", required={"id", "user_id"},
 *     @OA\Property(property="id", format="int64", type="integer", default=1, example=1),
 *     @OA\Property(property="user_id", format="int64", type="integer", default=1, example=1),
 *     @OA\Property(property="location_id", format="int64", type="integer", default=1, example=1),
 *     @OA\Property(property="location", format="object", type="object", nullable=true, anyOf={
 *       @OA\Schema(ref="#/components/schemas/Location"),
 *       @OA\Schema(nullable=true)
 *   }
 *     )
 * )
 */

class Path extends Model
{
    protected $fillable = [
        'user_id',
        'location_id'
    ];

    protected $visible = [
        'id',
        'user_id',
        'location_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the location that owns the point of path.
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     * Get the user that owns the point of path.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
