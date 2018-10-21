<?php

namespace App\Http\Controllers;

use App\Shop;

class ShopItemController extends Controller
{
    use Traits\ManyToManyTrait;

    const MODEL = Shop::class;
    const METHOD = 'items';
}
