<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
