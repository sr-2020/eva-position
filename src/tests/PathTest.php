<?php

use App\Http\Controllers\PathController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\JsonResponse;

class PathTest extends TestCase
{
    use DatabaseMigrations;

    const ROUTE = '/api/v1/paths';
    const CONTROLLER = PathController::class;

    /**
     * Create factory.
     *
     * @return \Laravel\Lumen\Application
     */
    protected function makeFactory()
    {
        $controller = static::CONTROLLER;
        $model = factory($controller::MODEL)->make();
        return $model;
    }

    /**
     * A basic test index.
     *
     * @return void
     */
    public function testIndex()
    {
        $collection = collect();
        for ($i = 0; $i <= 3; $i++) {
            $model = $this->makeFactory();
            $model->save();
            $collection->push($model->toArray());
        }

        $this->json('GET', static::ROUTE)
            ->seeStatusCode(JsonResponse::HTTP_OK);
    }

}
