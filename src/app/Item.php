<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
