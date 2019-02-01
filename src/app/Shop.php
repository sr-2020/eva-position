<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * #OA\Schema(schema="NewShop", required={"name"},
 *     #OA\Property(property="name", format="string", type="string"),
 * )
 */

/**
 *  #OA\Schema(
 *   schema="Shop",
 *   type="object",
 *   allOf={
 *       #OA\Schema(ref="#/components/schemas/NewShop"),
 *       #OA\Schema(
 *           required={"id"},
 *           #OA\Property(property="id", format="int64", type="integer"),
 *           #OA\Property(property="name", format="string", type="string"),
 *       )
 *   }
 * )
 */

class Shop extends Model
{
    protected $fillable = [
        'name'
    ];
    
    protected $visible = [
        'id',
        'name'
    ];
    
    /**
     * Get the items for the shop.
     */
    public function items()
    {
        return $this->belongsToMany('App\Item');
    }

}
