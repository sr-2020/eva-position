<?php

namespace App\Http\Controllers;

use App\User;

class UserItemController extends Controller
{
    use Traits\ManyToManyTrait;

    const MODEL = User::class;
    const METHOD = 'items';
}
