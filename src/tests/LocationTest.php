<?php

use App\Http\Controllers\LocationController;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Testing\DatabaseMigrations;

class LocationTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/locations';
    const CONTROLLER = LocationController::class;

    /**
     * A basic test update.
     *
     * @return void
     */
    public function testListUpdate()
    {
        $data = [
            [
                'id' => 1,
                'body' => [
                    'options' => [
                        'color' => '123456',
                    ]
                ]
            ],
            [
                'id' => 2,
                'body' => [
                    'options' => [
                        'color' => 'ff3456',
                    ]
                ]
            ]
        ];

        $this->json('PUT', static::ROUTE, $data, [
            'X-User-Id' => self::$userId
        ])
            ->seeStatusCode(JsonResponse::HTTP_OK);

        $this->json('GET', static::ROUTE . '/' . $data[0]['id'])
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJsonContains([
                'options' => $data[0]['body']['options']
            ]);

        $this->json('GET', static::ROUTE . '/' . $data[1]['id'])
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJsonContains([
                'options' => $data[1]['body']['options']
            ]);
    }
}
