<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Schema(schema="LoginCreds", required={"email", "password"},
 *     @OA\Property(property="email", format="string", type="string", example="test@email.com"),
 *     @OA\Property(property="password", format="string", type="string", example="secret")
 * )
 */

/**
 * @OA\Schema(schema="RegisterCreds", required={"email", "password"},
 *     @OA\Property(property="email", format="string", type="string", example="test@email.com"),
 *     @OA\Property(property="password", format="string", type="string", example="secret"),
 *     @OA\Property(property="name", format="string", type="string", example="Tom Sand"),
 * )
 */

/**
 * @OA\Schema(schema="UserApiKey", required={"email", "password"},
 *     @OA\Property(property="id", format="int64", type="integer", example=1),
 *     @OA\Property(property="api_key", format="string", type="string", example="em1JbEVqSnZlR0lPMlozenZ5YmpPUWdKSURiVGpnZmg="),
 * )
 */

/**
 * #OA\Schema(schema="NewUser", required={"name"},
 *     #OA\Property(property="name", format="string", type="string"),
 * )
 */

/**
 *  @OA\Schema(
 *   schema="User",
 *   type="object",
 *   allOf={
 *       @OA\Schema(
 *           required={"id"},
 *           @OA\Property(property="id", format="int64", type="integer", example=1),
 *           @OA\Property(property="router_id", format="int64", type="integer", example=2),
 *           @OA\Property(property="beacon_id", format="int64", type="integer", example=3),
 *           @OA\Property(property="name", format="string", type="string", example="User Name"),
 *           @OA\Property(property="email", format="string", type="string", example="test@email.com"),
 *           @OA\Property(property="updated_at", format="string", type="string", example="2019-01-26 20:00:57"),
 *           @OA\Property(property="beacon", format="object", type="object",
 *              ref="#/components/schemas/Beacon"
 *           )
 *       )
 *   }
 * )
*/

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'router_id',
        'beacon_id',
        'api_key'
    ];

    protected $visible = [
        'id',
        'router_id',
        'beacon_id',
        'name',
        'email',
        'updated_at'
    ];

    /**
     * Get router.
     */
    public function router()
    {
        return $this->belongsTo('App\Router');
    }

    /**
     * Get the post that owns the comment.
     */
    public function beacon()
    {
        return $this->belongsTo('App\Beacon');
    }

    /**
     * Get the items for the user.
     */
    public function items()
    {
        return $this->belongsToMany('App\Item');
    }

    /**
     * Get the shops for the user.
     */
    public function shops()
    {
        return $this->belongsToMany('App\Shop');
    }

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }
}
