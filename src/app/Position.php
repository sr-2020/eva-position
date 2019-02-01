<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Router;
use App\Beacon;

/**
 * @OA\Schema(schema="NewPosition", required={"name"},
 *     @OA\Property(property="positions", format="string", type="string"),
 * )
 */

/**
 *  @OA\Schema(
 *   schema="Position",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/NewPosition"),
 *       @OA\Schema(
 *           required={"id"},
 *           @OA\Property(property="id", format="int64", type="integer"),
 *           @OA\Property(property="user_id", format="int64", type="integer"),
 *           @OA\Property(property="routers", format="string", type="string"),
 *       )
 *   }
 * )
*/
class Position extends Model
{
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'routers' => 'array',
        'beacons' => 'array',
    ];

    protected $fillable = [
        'routers',
        'beacons',
    ];

    protected $visible = [
        'id',
        'user_id',
        'routers',
        'beacons',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            if (!is_array($model->routers)) {
                $model->routers = [];
            }
            if (!is_array($model->beacons)) {
                $model->beacons = [];
            }
        });

        static::created(function($model) {
            if (is_array($model->routers)) {
                foreach ($model->routers as $router) {
                    $validRouter = array_change_key_case($router, CASE_LOWER);
                    $routerModel = Router::firstOrNew([
                        'bssid' => $validRouter['bssid']
                    ]);
                    $routerModel->ssid = $validRouter['ssid'];
                    $routerModel->save();
                }
            }

            if (is_array($model->beacons)) {
                foreach ($model->beacons as $beacon) {
                    $validBeacon = array_change_key_case($beacon, CASE_LOWER);
                    $beaconModel = Beacon::firstOrNew([
                        'bssid' => $validBeacon['bssid']
                    ]);
                    $beaconModel->ssid = $validBeacon['ssid'];
                    $beaconModel->save();
                }
            }
        });
    }
}
