<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Pool;

class PositionCest
{
    static protected $userId;
    static protected $apiKey;

    static protected $url = '';
    static protected $route = '/positions';

    static protected $before = false;

    static protected $beacons = [
        'A' => [
            'ssid' => 'room_a',
            'bssid' => 'E9:DC:0E:20:E3:DC'
        ],
        'B' => [
            'ssid' => 'room_b',
            'bssid' => 'EA:93:BA:E7:99:82'
        ],
        'C' => [
            'ssid' => 'room_c',
            'bssid' => 'C0:DA:B3:09:A9:FB'
        ]
    ];

    static protected $location = [
        'A' => 1,
        'B' => 2,
        'C' => 2
    ];

    public function _before(\ApiTester $I)
    {
        if (static::$before) {
            return ;
        }

        static::$url = $I->getPublicScenario()->current('')['modules']['REST']->_getConfig('url') . '/';

        try {
            $data = [
                'email' => 'test@evarun.ru',
                'password' => 'secret'
            ];
            $I->haveHttpHeader('Content-Type', 'application/json');
            $I->sendPOST('/login', $data);
            $jsonResponse = json_decode($I->grabResponse());
            self::$userId = $jsonResponse->id;
            self::$apiKey = $jsonResponse->api_key;
        } catch (Exception $e) {
            $data = [
                'name' => 'Мистер T',
                'email' => 'test@evarun.ru',
                'password' => 'secret'
            ];
            $I->haveHttpHeader('Content-Type', 'application/json');
            $I->sendPOST('/register', $data);
        }
        $jsonResponse = json_decode($I->grabResponse());
        self::$userId = $jsonResponse->id;
        self::$apiKey = $jsonResponse->api_key;

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

        $I->sendGET('/users/' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
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

        $I->sendGET('/users/' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
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

        $I->sendGET('/users/' . self::$userId);
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

        $I->sendGET('/users/' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'location_id' => self::$location['A'],
            'location' => [
                'id' => self::$location['A']
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

        $I->sendGET('/users/' . self::$userId);
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

        $I->sendGET('/users/' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'location_id' => self::$location['B'],
            'location' => [
                'id' => self::$location['B']
            ]
        ]);
    }

    public function thirdBeaconLowerBssidTest(ApiTester $I)
    {
        $lowerBeaconA = self::$beacons['A'];
        $lowerBeaconA['bssid'] = strtolower($lowerBeaconA['bssid']);
        $lowerBeaconB = self::$beacons['B'];
        $lowerBeaconB['bssid'] = strtolower($lowerBeaconB['bssid']);

        $beacons = [
            $lowerBeaconA + ['level' => -50],
            $lowerBeaconB + ['level' => -30]
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

        $I->sendGET('/users/' . self::$userId);
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

        $I->sendGET('/users/' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'location_id' => self::$location['B'],
            'location' => [
                'id' => self::$location['B']
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
