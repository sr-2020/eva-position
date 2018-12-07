<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="NewItem", required={"name"},
 *     @OA\Property(property="name", format="string", type="string"),
 * )
 */

/**
 *  @OA\Schema(
 *   schema="Item",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/NewItem"),
 *       @OA\Schema(
 *           required={"id"},
 *           @OA\Property(property="id", format="int64", type="integer"),
 *           @OA\Property(property="name", format="string", type="string"),
 *       )
 *   }
 * )
 */

class Item extends Model
{
    protected $fillable = [
        'name',
        'price',
        'user_id',
        'shop_id',
    ];

    protected $visible = [
        'id',
        'name',
        'price',
        'user_id',
        'shop_id',
    ];

    protected $casts = [
        'price' => 'integer',
        'user_id' => 'integer',
        'shop_id' => 'integer',
    ];
}
