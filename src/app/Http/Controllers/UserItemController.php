<?php

namespace App\Http\Controllers;

use App\User;

class UserItemController extends Controller
{
    use Traits\ManyToManyTrait;

    const Model = User::class;
    const Method = 'items';
}
