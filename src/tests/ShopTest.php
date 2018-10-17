<?php

use App\Http\Controllers\ShopController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ShopTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const Route = '/api/v1/shops';
    const Controller = ShopController::class;
}
