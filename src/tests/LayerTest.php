<?php

use App\Http\Controllers\LayerController;
use Laravel\Lumen\Testing\DatabaseMigrations;

class LayerTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/layers';
    const CONTROLLER = LayerController::class;
}
