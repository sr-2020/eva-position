<?php

namespace App\Http\Controllers;

use App\User;

class UserShopController extends Controller
{
    use Traits\ManyToManyTrait;

    const MODEL = User::class;
    const METHOD = 'shops';
}
