<?php

use App\Http\Controllers\RouterController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class RouterTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/routers';
    const CONTROLLER = RouterController::class;
}
