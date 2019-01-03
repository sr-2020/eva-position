<?php

use App\Http\Controllers\PositionController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class PositionTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/positions';
    const CONTROLLER = PositionController::class;
}
