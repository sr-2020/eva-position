<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Schema(schema="NewUser", required={"location_id"},
 *     @OA\Property(property="location_id", format="int64", type="integer", nullable=true, example=1),
 * )
 */

/**
 * @OA\Schema(
 *    schema="User",
 *    required={"id"},
 *    @OA\Property(property="id", format="int64", type="integer", example=1),
 *    @OA\Property(property="location_id", format="int64", type="integer", nullable=true, example=1),
 *    @OA\Property(property="created_at", format="string", type="string", example="2019-01-26 20:00:00"),
 *    @OA\Property(property="updated_at", format="string", type="string", example="2019-01-26 20:00:57"),
 *    @OA\Property(property="location", format="object", type="object", nullable=true,
 *        ref="#/components/schemas/Location"
 *    )
 *    )
 * )
*/

class User extends Model
{
    protected $fillable = [
        'location_id',
    ];

    protected $visible = [
        'id',
        'location_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the location where user is.
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
