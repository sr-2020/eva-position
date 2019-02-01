<?php

use App\Http\Controllers\BeaconController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class BeaconTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/beacons';
    const CONTROLLER = BeaconController::class;
}
