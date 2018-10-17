<?php

use App\Http\Controllers\UserItemController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UserItemTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const Route = '/api/v1/users';
    const Controller = UserItemController::class;
}
