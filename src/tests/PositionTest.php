<?php

use App\Http\Controllers\PositionController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\JsonResponse;
use App\User;

class PositionTest extends TestCase
{
    use DatabaseMigrations;

    const ROUTE = '/api/v1/positions';
    const CONTROLLER = PositionController::class;

    static protected $beacons = [
        'L1-1' => [
            'ssid' => 'B1',
            'bssid' => 'E9:DC:0E:20:E3:DC'
        ],
        'L1-2' => [
            'ssid' => 'B2',
            'bssid' => 'D2:7E:91:02:AB:64'
        ],
        'L1-3' => [
            'ssid' => 'B3',
            'bssid' => 'F3:86:35:4C:6E:03'
        ],
        'L2-1' => [
            'ssid' => 'B4',
            'bssid' => 'C0:DA:B3:09:A9:FB'
        ],
        'L2-2' => [
            'ssid' => 'B5',
            'bssid' => 'F6:A3:B4:E1:D1:15'
        ],
        'L3-1' => [
            'ssid' => 'B6',
            'bssid' => 'F3:8F:DE:2F:66:C9'
        ],
        'W' => [
            'ssid' => 'B7',
            'bssid' => 'F3:8F:00:2F:00:C9'
        ]
    ];

    static protected $location = [
        'L1-1' => 1,
        'L1-2' => 1,
        'L1-3' => 1,
        'L2-1' => 2,
        'L2-2' => 2,
        'L3-1' => 3,
    ];

    static protected $locationId = [
        1 => 1,
        2 => 1,
        3 => 1,
        4 => 2,
        5 => 2,
        6 => 3,
    ];

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
                'X-User-Id' => self::$userId
            ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED)
            ->seeJsonStructure([
                'id',
                'user_id',
                'location_id',
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
            'X-User-Id' => self::$userId
        ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED)
            ->seeJsonStructure([
                'id',
                'user_id',
                'location_id',
                'created_at',
            ]);

        $this->json('GET', '/api/v1/users/' . $user->id, [], [
            'X-User-Id' => self::$userId
        ])
            ->seeStatusCode(JsonResponse::HTTP_OK);

        $json = json_decode($this->response->content());
        $this->assertTrue(date('Y-m-d H:i:s') >= $json->updated_at);
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
            'X-User-Id' => 0
        ])
            ->seeStatusCode(JsonResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateNotFoundSuccess()
    {
        $beacons = [
            self::$beacons['L1-1'] + ['level' => -10]
        ];

        $this->json('POST', static::ROUTE, [
            'beacons' => $beacons
        ], [
            'X-User-Id' => 1000
        ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateWrongBeaconFail()
    {
        $beacons = [
            self::$beacons['L1-1'] + ['level' => 234732847364]
        ];

        $this->json('POST', static::ROUTE, [
            'beacons' => $beacons
        ], [
            'X-User-Id' => 1
        ])
            ->seeStatusCode(JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testOneBeaconOneLocationSuccess()
    {
        $beacons = [
            self::$beacons['L1-1'] + ['level' => -10]
        ];

        $this->json('POST', static::ROUTE, [
            'beacons' => $beacons
        ], [
            'X-User-Id' => self::$userId
        ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED);

        $json = json_decode($this->response->content());
        $this->assertEquals(1, $json->location_id);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testTwoBeaconOneLocationSuccess()
    {
        $beacons = [
            self::$beacons['L1-1'] + ['level' => -30],
            self::$beacons['L1-2'] + ['level' => -10],
        ];

        $this->json('POST', static::ROUTE, [
            'beacons' => $beacons
        ], [
            'X-User-Id' => self::$userId
        ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED);

        $json = json_decode($this->response->content());
        $this->assertEquals(1, $json->location_id);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testTwoBeaconTwoLocationSuccess()
    {
        $beacons = [
            self::$beacons['L1-1'] + ['level' => -30],
            self::$beacons['L2-1'] + ['level' => -10],
        ];

        $this->json('POST', static::ROUTE, [
            'beacons' => $beacons
        ], [
            'X-User-Id' => self::$userId
        ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED);

        $json = json_decode($this->response->content());
        $this->assertEquals(2, $json->location_id);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testThreeBeaconThreeLocationSuccess()
    {
        $beacons = [
            self::$beacons['L1-1'] + ['level' => -50],
            self::$beacons['L2-1'] + ['level' => -30],
            self::$beacons['L3-1'] + ['level' => -10],
        ];

        $this->json('POST', static::ROUTE, [
            'beacons' => $beacons
        ], [
            'X-User-Id' => self::$userId
        ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED);

        $json = json_decode($this->response->content());
        $this->assertEquals(3, $json->location_id);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testWrongBeaconSuccess()
    {
        $beacons = [
            self::$beacons['L1-1'] + ['level' => -50],
            self::$beacons['W'] + ['level' => -30],
        ];

        $this->json('POST', static::ROUTE, [
            'beacons' => $beacons
        ], [
            'X-User-Id' => self::$userId
        ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED);

        $json = json_decode($this->response->content());
        $this->assertEquals(1, $json->location_id);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testKeepBeaconBeaconSuccess()
    {
        $beacons = [
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -60]],
            [],
            [],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
            [],
            [],
            [],
        ];
        $setBeacons = [1, 1, 1, 4, 4, 4, 4];

        foreach ($beacons as $index => $item) {
            $this->json('POST', static::ROUTE, [
                'beacons' => $item
            ], [
                'X-User-Id' => self::$userId
            ])
                ->seeStatusCode(JsonResponse::HTTP_CREATED);

            $this->json('GET', '/api/v1/users/1', [], [
                'X-User-Id' => self::$userId
            ])
                ->seeStatusCode(JsonResponse::HTTP_OK);

            $json = json_decode($this->response->content());
            $this->assertEquals(self::$locationId[$setBeacons[$index]], $json->location_id);
        }
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testPositionsThreeSuccess()
    {
        $beacons = [
            [self::$beacons['L1-1'] + ['level' => -20], self::$beacons['L2-1'] + ['level' => -30]],
            [self::$beacons['L1-1'] + ['level' => -30], self::$beacons['L2-1'] + ['level' => -40]],
            [self::$beacons['L1-1'] + ['level' => -40], self::$beacons['L2-1'] + ['level' => -50]],
        ];
        $setBeacons = [1, 1, 1];

        foreach ($beacons as $index => $item) {
            $this->json('POST', static::ROUTE, [
                'beacons' => $item
            ], [
                'X-User-Id' => self::$userId
            ])
                ->seeStatusCode(JsonResponse::HTTP_CREATED);

            $this->json('GET', '/api/v1/users/1', [], [
                'X-User-Id' => self::$userId
            ])
                ->seeStatusCode(JsonResponse::HTTP_OK);

            $json = json_decode($this->response->content());
            $this->assertEquals(self::$locationId[$setBeacons[$index]], $json->location_id);
        }
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testOneBeaconUpdateLocationSuccess()
    {
        $beacons = [
            self::$beacons['L1-1'] + ['level' => -10]
        ];

        for ($i = 0; $i < 2; $i++) {
            $this->json('POST', static::ROUTE, [
                'beacons' => $beacons
            ], [
                'X-User-Id' => self::$userId
            ])
                ->seeStatusCode(JsonResponse::HTTP_CREATED);

            $json = json_decode($this->response->content());
            $this->assertEquals(1, $json->location_id);
            $postionCreatedAt = $json->created_at;

            $this->json('GET', '/api/v1/users/1', [], [
                'X-User-Id' => self::$userId
            ])
                ->seeStatusCode(JsonResponse::HTTP_OK);

            $json = json_decode($this->response->content());
            $this->assertNotEquals(null, $json->updated_at);
            $this->assertGreaterThanOrEqual($postionCreatedAt,  $json->updated_at);
        }
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testPositionsFlowSuccess()
    {
        config(['position.strategy' => 3]);
        $beacons = [
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -60]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -60]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -60]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -60]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
        ];
        $setBeacons = [null, 4, 4, 4, 4, 4, 4, 4, 1, 1, 4];

        foreach ($beacons as $index => $item) {
            $this->json('POST', static::ROUTE, [
                'beacons' => $item
            ], [
                'X-User-Id' => self::$userId
            ])
                ->seeStatusCode(JsonResponse::HTTP_CREATED);

            $this->json('GET', '/api/v1/users/1', [], [
                'X-User-Id' => self::$userId
            ])
                ->seeStatusCode(JsonResponse::HTTP_OK);

            if (null !== $setBeacons[$index]) {
                $json = json_decode($this->response->content());
                $this->assertEquals(self::$locationId[$setBeacons[$index]], $json->location_id);
            }
        }
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testPositionsFlowLostSuccess()
    {
        config(['position.strategy' => 3]);
        $beacons = [
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -60]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -60]],
            [],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -60]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -60]],
            [],
            [],
            [],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
            [],
            [],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
            [self::$beacons['L1-1'] + ['level' => -50], self::$beacons['L2-1'] + ['level' => -40]],
        ];
        $setBeacons = [null, 1, 1, 1, 1, 1, 1, 0, 0, 4, 4, 4, 4, 4];

        foreach ($beacons as $index => $item) {
            $this->json('POST', static::ROUTE, [
                'beacons' => $item
            ], [
                'X-User-Id' => self::$userId
            ])
                ->seeStatusCode(JsonResponse::HTTP_CREATED);

            $this->json('GET', '/api/v1/users/1', [], [
                'X-User-Id' => self::$userId
            ])
                ->seeStatusCode(JsonResponse::HTTP_OK);

            if (!empty($setBeacons[$index])) {
                $json = json_decode($this->response->content());
                $this->assertEquals(self::$locationId[$setBeacons[$index]], $json->location_id);
            }
        }
    }
}
