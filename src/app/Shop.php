<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
