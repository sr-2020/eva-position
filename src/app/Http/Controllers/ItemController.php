<?php

namespace App\Http\Controllers;

use App\Item;

class ItemController extends Controller
{
    use Traits\CrudTrait;

    const MODEL = Item::class;
}
