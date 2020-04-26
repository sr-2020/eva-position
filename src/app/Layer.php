<?php

namespace App;

/**
 * @OA\Schema(schema="NewLayer", required={"name"},
 *     @OA\Property(property="name", format="string", type="string", default="Level1", example="Level1")
 * )
 */


/**
 * @OA\Schema(schema="Layer", required={"id", "name"},
 *    @OA\Property(property="id", format="int64", type="integer", example=1),
 *    @OA\Property(property="name", format="string", type="string", example="Level1")
 * )
 */

class Layer extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $visible = [
        'id',
        'name',
    ];

    /**
     * @var array
     */
    protected static $rules = [
        'common' => [],
        'create' => [],
        'update' => [],
    ];
}
