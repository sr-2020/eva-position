<?php

use App\Http\Controllers\LocationController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class LocationTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/locations';
    const CONTROLLER = LocationController::class;
}
