<?php

namespace App\Http\Controllers;

use App\User;

class UserShopController extends Controller
{
    use Traits\ManyToManyTrait;

    const Model = User::class;
    const Method = 'shops';    
}
