<?php

use App\Http\Controllers\ShopController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ShopTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/shops';
    const CONTROLLER = ShopController::class;
}
