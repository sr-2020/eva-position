<?php

use App\Http\Controllers\PositionController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\JsonResponse;

class PositionTest extends TestCase
{
    use DatabaseMigrations;

    const ROUTE = '/api/v1/positions';
    const CONTROLLER = PositionController::class;

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
     * A basic test create.
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $model = $this->makeFactory();
        $user = factory(App\User::class)->make();
        $user->save();

        $this->json('POST', static::ROUTE, $model->toArray(), [
                'Authorization' => $user->api_key
            ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED)
            ->seeJsonEquals($model->toArray() + [
                'id' => 1,
                'user_id' => $user->id
            ]);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateUnauthorized()
    {
        $model = $this->makeFactory();
        $user = factory(App\User::class)->make();
        $user->save();

        $this->json('POST', static::ROUTE, $model->toArray(), [
            'Authorization' => 'token'
        ])
            ->seeStatusCode(JsonResponse::HTTP_UNAUTHORIZED);
    }
}
