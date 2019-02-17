<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * #OA\Schema(schema="NewRouter", required={"name"},
 *     #OA\Property(property="ssid", format="string", type="string"),
 *     #OA\Property(property="bssid", format="string", type="string"),
 * )
 */

/**
 * @OA\Schema(schema="RouterSignal", required={"ssid", "bssid", "level"},
 *    @OA\Property(property="ssid", format="string", type="string", example="router1"),
 *    @OA\Property(property="bssid", format="string", type="string", example="b0:dd:dd:dd:00:0a"),
 *    @OA\Property(property="level", format="int64", type="integer", example=-50),
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
