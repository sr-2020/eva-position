<?php

namespace App\Http\Controllers;

use App\Shop;

class ShopItemController extends Controller
{
    use Traits\ManyToManyTrait;

    const Model = Shop::class;
    const Method = 'items';
}
