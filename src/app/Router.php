<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="NewRouter", required={"name"},
 *     @OA\Property(property="ssid", format="string", type="string"),
 *     @OA\Property(property="bssid", format="string", type="string"),
 * )
 */

/**
 *  @OA\Schema(
 *   schema="Router",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/NewRouter"),
 *       @OA\Schema(
 *           required={"id"},
 *           @OA\Property(property="id", format="int64", type="integer"),
 *           @OA\Property(property="ssid", format="string", type="string"),
 *           @OA\Property(property="bssid", format="string", type="string"),
 *       )
 *   }
 * )
*/
class Router extends Model
{
    protected $fillable = [
        'ssid',
        'bssid',
    ];

    protected $visible = [
        'id',
        'ssid',
        'bssid',
    ];

    protected $with = ['users'];

    /**
     * Get users.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
