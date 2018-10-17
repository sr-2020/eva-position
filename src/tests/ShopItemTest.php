<?php

use App\Http\Controllers\ShopItemController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ShopItemTest extends TestCase
{
    use DatabaseMigrations;
    use TestManyToManyTrait;

    const Route = '/api/v1/shops';
    const Controller = ShopItemController::class;
}
