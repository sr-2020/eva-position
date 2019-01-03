<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Router;

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
        'routers' => 'array'
    ];

    protected $fillable = [
        'routers',
    ];

    protected $visible = [
        'id',
        'routers',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($model) {
            foreach ($model->routers as $router) {
                $validRouter = array_change_key_case($router, CASE_LOWER);
                $routerModel = Router::firstOrNew([
                    'bssid' => $validRouter['bssid']
                ]);
                $routerModel->ssid = $validRouter['ssid'];
                $routerModel->save();
            }
        });
    }
}
