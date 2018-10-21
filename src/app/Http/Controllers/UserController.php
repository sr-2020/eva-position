<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    use Traits\CrudTrait;
    
    const MODEL = User::class;
}
