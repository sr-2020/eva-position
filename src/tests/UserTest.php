<?php

use App\Http\Controllers\UserController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\JsonResponse;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/users';
    const CONTROLLER = UserController::class;

    /**
     * A basic test index.
     *
     * @return void
     */
    public function testListSuccess()
    {
        $model = $this->makeFactory();

        $model->location_id = 1;
        $model->save();

        $this->json('GET', static::ROUTE)
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJsonStructure([[
                'id',
                'location',
                'location_id',
                'created_at',
                'updated_at',
                'location_updated_at',
            ], [
                'id',
                'location',
                'location_id',
                'created_at',
                'updated_at',
                'location_updated_at',
            ]]);

        $json = json_decode($this->response->content());
        $this->assertEquals(null, $json[0]->location_id);
        $this->assertEquals(1, $json[1]->location_id);

        $this->assertEquals($json[0]->updated_at, $json[0]->location_updated_at);
        $this->assertEquals($json[1]->updated_at, $json[1]->location_updated_at);
    }

    /**
     * A basic test index.
     *
     * @return void
     */
    public function testListFilterSuccess()
    {
        $model = $this->makeFactory();

        $model->location_id = 1;
        $model->save();

        $this->json('GET', static::ROUTE . '?filter[location_id]=1')
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJsonStructure([[
                'id',
                'location',
                'location_id',
                'created_at',
                'updated_at',
                'location_updated_at',
            ]]);

        $json = json_decode($this->response->content());
        $this->assertEquals(1, $json[0]->location_id);
        $this->assertEquals(1, $json[0]->location->id);
    }
}
