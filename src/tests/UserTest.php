<?php

use App\Http\Controllers\UserController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const Route = '/api/v1/users';
    const Controller = UserController::class;
}
