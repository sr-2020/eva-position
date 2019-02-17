<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Pool;

class PositionCest
{
    static protected $userId = 1;
    static protected $apiKey = '';
    static protected $createdId = 0;
    static protected $url = '';
    static protected $route = '/positions';

    static protected $before = false;

    static protected $beacons = [
        'A' => [
            'ssid' => 'broom_a',
            'bssid' => 'b0:0a:95:9d:00:0a'
        ],
        'B' => [
            'ssid' => 'broom_b',
            'bssid' => 'b0:0a:95:9d:00:0b'
        ]
    ];

    public function _before(\ApiTester $I)
    {
        if (static::$before) {
            return ;
        }

        static::$url = $I->getPublicScenario()->current('')['modules']['REST']->_getConfig('url') . '/';

        try {
            $data = [
                'email' => 'test@email.com',
                'password' => 'secret'
            ];
            $I->haveHttpHeader('Content-Type', 'application/json');
            $I->sendPOST('/login', $data);

            $jsonResponse = json_decode($I->grabResponse());
            self::$apiKey = $jsonResponse->api_key;
            self::$createdId = $jsonResponse->id;
        } catch (Exception $e) {
            $data = [
                'name' => 'User Test',
                'email' => 'test@email.com',
                'password' => 'secret'
            ];
            $I->haveHttpHeader('Content-Type', 'application/json');
            $I->sendPOST('/users', $data);

            $jsonResponse = json_decode($I->grabResponse());
            self::$apiKey = $jsonResponse->api_key;
            self::$createdId = $jsonResponse->id;
        }

        static::$before = true;
    }

    public function indexTest(ApiTester $I)
    {
        $I->sendGET(self::$route);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([]);
    }

    public function firstRouterTest(ApiTester $I)
    {
        $routers = [
            [
                'ssid' => 'room_a',
                'bssid' => '00:0a:95:9d:00:0a',
                'level' => -10
            ],
            [
                'ssid' => 'room_b',
                'bssid' => '00:0a:95:9d:00:0b',
                'level' => -30
            ]
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', self::$apiKey);
        $I->sendPOST(self::$route, [
            'routers' => $routers
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'routers' => 'array'
        ]);
        $I->canSeeResponseContainsJson([
            'routers' => $routers
        ]);

        $I->sendGET('/users/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'router_id' => 1
        ]);
    }

    public function secondRouterTest(ApiTester $I)
    {
        $routers = [
            [
                'ssid' => 'room_a',
                'BSSID' => '00:0a:95:9d:00:0a',
                'level' => -50
            ],
            [
                'ssid' => 'room_b',
                'BSSID' => '00:0a:95:9d:00:0b',
                'level' => -30
            ]
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', self::$apiKey);
        $I->sendPOST(self::$route, [
            'routers' => $routers
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'routers' => 'array'
        ]);
        $I->canSeeResponseContainsJson([
            'routers' => $routers
        ]);

        $I->sendGET('/users/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'router_id' => 2
        ]);
    }

    public function firstBeaconTest(ApiTester $I)
    {
        $beacons = [
            self::$beacons['A'] + ['level' => -10],
            self::$beacons['B'] + ['level' => -30]
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', self::$apiKey);
        $I->sendPOST(self::$route, [
            'beacons' => $beacons
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'routers' => 'array',
            'beacons' => 'array',
        ]);
        $I->canSeeResponseContainsJson([
            'beacons' => $beacons
        ]);

        $I->sendGET('/users/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'beacon' => [
                'bssid' => self::$beacons['A']['bssid']
            ]
        ]);

        $I->sendGET('/paths?limit=1&sort=-id&filter[user_id]=' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            [
                'user_id' => self::$userId,
                'beacon' => [
                    'bssid' => self::$beacons['A']['bssid']
                ]
            ]
        ]);
    }

    public function secondBeaconTest(ApiTester $I)
    {
        $beacons = [
            self::$beacons['A'] + ['level' => -50],
            self::$beacons['B'] + ['level' => -30]
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', self::$apiKey);
        $I->sendPOST(self::$route, [
            'beacons' => $beacons
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'routers' => 'array',
            'beacons' => 'array',
        ]);
        $I->canSeeResponseContainsJson([
            'beacons' => $beacons
        ]);

        $I->sendGET('/users/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'beacon' => [
                'bssid' => self::$beacons['B']['bssid']
            ]
        ]);

        $I->sendGET('/paths?limit=1&sort=-id&filter[user_id]=' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            [
                'user_id' => self::$userId,
                'beacon' => [
                    'bssid' => self::$beacons['B']['bssid']
                ]
            ]
        ]);
    }

    public function changeBeaconTest(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', self::$apiKey);
        $I->sendPOST(self::$route, [
            'beacons' => [
                self::$beacons['A'] + ['level' => -10],
                self::$beacons['B'] + ['level' => -30]
            ]
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);

        $I->sendPOST(self::$route, [
            'beacons' => [
                self::$beacons['A'] + ['level' => -50],
                self::$beacons['B'] + ['level' => -30]
            ]
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);

        $I->sendGET('/paths?limit=2&sort=-id&filter[user_id]=' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            [
                'user_id' => self::$userId,
                'beacon' => [
                    'bssid' => self::$beacons['A']['bssid']
                ]
            ],
            [
                'user_id' => self::$userId,
                'beacon' => [
                    'bssid' => self::$beacons['B']['bssid']
                ]
            ]
        ]);
    }

    public function doubleEmptyBeaconTest(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', self::$apiKey);
        $I->sendPOST(self::$route, [
            'beacons' => [
                self::$beacons['A'] + ['level' => -10],
                self::$beacons['B'] + ['level' => -30]
            ]
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);

        for ($i = 0; $i < 3; $i++) {
            $I->sendPOST(self::$route, [
                'beacons' => []
            ]);
            $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        }

        $I->sendGET('/paths?limit=2&sort=-id&filter[user_id]=' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            [
                'user_id' => self::$userId,
                'beacon' => null
            ],
            [
                'user_id' => self::$userId,
                'beacon' => [
                    'bssid' => self::$beacons['A']['bssid']
                ]
            ]
        ]);
    }

    public function doubleBeaconTest(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', self::$apiKey);
        $I->sendPOST(self::$route, [
            'beacons' => [
                self::$beacons['A'] + ['level' => -10],
                self::$beacons['B'] + ['level' => -30]
            ]
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);

        for ($i = 0; $i < 3; $i++) {
            $I->sendPOST(self::$route, [
                'beacons' => [
                    self::$beacons['A'] + ['level' => -50],
                    self::$beacons['B'] + ['level' => -30]
                ]
            ]);
            $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        }

        $I->sendGET('/paths?limit=2&sort=-id&filter[user_id]=' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            [
                'user_id' => self::$userId,
                'beacon' => [
                    'bssid' => self::$beacons['A']['bssid']
                ]
            ],
            [
                'user_id' => self::$userId,
                'beacon' => [
                    'bssid' => self::$beacons['B']['bssid']
                ]
            ]
        ]);
    }

    public function parallelDoubleBeaconTest(ApiTester $I)
    {
        $client = new Client([
            'base_uri' => static::$url
        ]);

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', self::$apiKey);
        $I->sendPOST(self::$route, [
            'beacons' => [
                self::$beacons['A'] + ['level' => -10],
                self::$beacons['B'] + ['level' => -30]
            ]
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);

        $requests = function ($total) {
            $route = substr(self::$route, 1);
            $beaconA = [
                'beacons' => [
                    self::$beacons['A'] + ['level' => -50],
                    self::$beacons['B'] + ['level' => -30]
                ]
            ];

            for ($i = 0; $i < $total; $i++) {
                yield new Request('POST', $route, [
                        'Content-Type' => 'application/json',
                        'Authorization' => self::$apiKey
                    ], json_encode($beaconA));
            }
        };

        $pool = new Pool($client, $requests(2), [
            'concurrency' => 2,
        ]);

        $promise = $pool->promise();
        $promise->wait();

        $I->sendGET('/paths?limit=2&sort=-id&filter[user_id]=' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }
}
