<?php

use App\Http\Controllers\ItemController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ItemTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const Route = '/api/v1/items';
    const Controller = ItemController::class;
}
