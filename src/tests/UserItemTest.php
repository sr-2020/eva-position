<?php

use App\Http\Controllers\UserItemController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UserItemTest extends TestCase
{
    use DatabaseMigrations;
    use TestManyToManyTrait;

    const ROUTE = '/api/v1/users';
    const CONTROLLER = UserItemController::class;
}
