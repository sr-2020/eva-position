<?php

use App\Http\Controllers\UserController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/users';
    const CONTROLLER = UserController::class;
}
