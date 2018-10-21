<?php

use App\Http\Controllers\ItemController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ItemTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/items';
    const CONTROLLER = ItemController::class;
}
