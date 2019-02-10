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

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $model = $this->makeFactory();
        $this->json('POST', static::ROUTE, $model->toArray(), [
                'Authorization' => self::$apiKey
            ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED)
            ->seeJsonStructure([
                'id',
                'user_id',
                'beacons',
                'created_at',
            ]);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateEmptySuccess()
    {
        $user = App\User::find(1);
        $this->json('POST', static::ROUTE, [], [
            'Authorization' => self::$apiKey
        ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED)
            ->seeJsonStructure([
                'id',
                'user_id',
                'beacons',
                'created_at',
            ]);

        $this->json('GET', '/api/v1/users/' . $user->id, [], [
            'Authorization' => $user->api_key
        ])
            ->seeStatusCode(JsonResponse::HTTP_OK);

        $json = json_decode($this->response->content());
        $this->assertTrue(date('Y-m-d H:i:s') <= $json->updated_at);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateUnauthorized()
    {
        $model = $this->makeFactory();
        $this->json('POST', static::ROUTE, $model->toArray(), [
            'Authorization' => 'token'
        ])
            ->seeStatusCode(JsonResponse::HTTP_UNAUTHORIZED);
    }
}
