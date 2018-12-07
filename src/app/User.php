<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="NewUser", required={"name"},
 *     @OA\Property(property="name", format="string", type="string"),
 * )
 */

/**
 *  @OA\Schema(
 *   schema="User",
 *   type="object",
 *   allOf={
 *       @OA\Schema(ref="#/components/schemas/NewUser"),
 *       @OA\Schema(
 *           required={"id"},
 *           @OA\Property(property="id", format="int64", type="integer"),
 *           @OA\Property(property="name", format="string", type="string"),
 *       )
 *   }
 * )
*/
class User extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $visible = [
        'id',
        'name'
    ];

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
}
