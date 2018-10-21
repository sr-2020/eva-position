<?php

use App\Http\Controllers\ShopItemController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ShopItemTest extends TestCase
{
    use DatabaseMigrations;
    use TestManyToManyTrait;

    const ROUTE = '/api/v1/shops';
    const CONTROLLER = ShopItemController::class;
}
