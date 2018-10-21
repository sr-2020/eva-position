<?php

use App\Http\Controllers\UserShopController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UserShopTest extends TestCase
{
    use DatabaseMigrations;
    use TestManyToManyTrait;

    const ROUTE = '/api/v1/users';
    const CONTROLLER = UserShopController::class;
}
