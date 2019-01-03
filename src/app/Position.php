<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
