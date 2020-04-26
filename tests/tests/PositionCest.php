<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Pool;

class PositionCest
{
    static protected $userId = 1;

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
            'bssid' => 'C0:DA:B3:09:A9:FB'
        ],
        'C' => [
            'ssid' => 'room_b',
            'bssid' => 'F6:A3:B4:E1:D1:15'
        ]
    ];

    static protected $location = [
        'A' => 1,
        'B' => 2,
        'C' => 2
    ];

//    public function _before(\ApiTester $I)
//    {
//        if (static::$before) {
//            return ;
//        }
//
//        static::$url = $I->getPublicScenario()->current('')['modules']['REST']->_getConfig('url') . '/';
//
//        try {
//            $data = [
//                'email' => 'test@evarun.ru',
//                'password' => 'secret'
//            ];
//            $I->haveHttpHeader('Content-Type', 'application/json');
//            $I->sendPOST('/login', $data);
//            $jsonResponse = json_decode($I->grabResponse());
//            self::$userId = $jsonResponse->id;
//            self::$apiKey = $jsonResponse->api_key;
//        } catch (Exception $e) {
//            $data = [
//                'name' => 'Мистер T',
//                'email' => 'test@evarun.ru',
//                'password' => 'secret'
//            ];
//            $I->haveHttpHeader('Content-Type', 'application/json');
//            $I->sendPOST('/register', $data);
//        }
//        $jsonResponse = json_decode($I->grabResponse());
//        self::$userId = $jsonResponse->id;
//        self::$apiKey = $jsonResponse->api_key;
//
//        static::$before = true;
//    }

    public function indexTest(ApiTester $I)
    {
        $I->sendGET(self::$route);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([]);
    }

    public function firstBeaconTest(ApiTester $I)
    {
        $lat = -63.4;
        $lng = 12.7;
        $type = 1;

        $beacons = [
            self::$beacons['A'] + ['level' => -10],
            self::$beacons['B'] + ['level' => -30]
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
        $I->sendPOST(self::$route, [
            'beacons' => $beacons,
            'lat' => $lat,
            'lng' => $lng,
            'type' => $type,
        ]);

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'location_id' => 'integer',
            'lat' => 'float',
            'lng' => 'float',
            'type' => 'integer'
        ]);

        $I->sendGET('/users/' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'location' => [
                'id' => self::$location['A']
            ]
        ]);

        $I->sendGET('/paths?limit=1&sort=-id&filter[user_id]=' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            [
                'user_id' => self::$userId,
                'location' => [
                    'id' => self::$location['A']
                ]
            ]
        ]);
    }

    public function secondBeaconTest(ApiTester $I)
    {
        if ('production' === $I->getEnv()) {
            $I->getPublicScenario()->skip('Skip for production!');
        }

        $beacons = [
            self::$beacons['A'] + ['level' => -50],
            self::$beacons['B'] + ['level' => -30]
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
        $I->sendPOST(self::$route, [
            'beacons' => $beacons
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'location_id' => 'integer',
        ]);

        $I->sendGET('/users/' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'location' => [
                'id' => self::$location['B']
            ]
        ]);

//        $I->sendGET('/paths?limit=1&sort=-id&filter[user_id]=' . self::$userId);
//        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
//        $I->seeResponseIsJson();
//        $I->canSeeResponseContainsJson([
//            [
//                'user_id' => self::$userId,
//                'location' => [
//                    'id' => self::$location['B']
//                ]
//            ]
//        ]);
    }

    public function thirdBeaconLowerBssidTest(ApiTester $I)
    {
        if ('production' === $I->getEnv()) {
            $I->getPublicScenario()->skip('Skip for production!');
        }

        $lowerBeaconA = self::$beacons['A'];
        $lowerBeaconA['bssid'] = strtolower($lowerBeaconA['bssid']);
        $lowerBeaconB = self::$beacons['B'];
        $lowerBeaconB['bssid'] = strtolower($lowerBeaconB['bssid']);

        $beacons = [
            $lowerBeaconA + ['level' => -50],
            $lowerBeaconB + ['level' => -30]
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
        $I->sendPOST(self::$route, [
            'beacons' => $beacons
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'location_id' => 'integer',
        ]);

        $I->sendGET('/users/' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            'location' => [
                'id' => self::$location['B']
            ]
        ]);

        $I->sendGET('/paths?limit=1&sort=-id&filter[user_id]=' . self::$userId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([
            [
                'user_id' => self::$userId,
                'location' => [
                    'id' => self::$location['B']
                ]
            ]
        ]);
    }

    public function changeBeaconTest(ApiTester $I)
    {
        if ('production' === $I->getEnv()) {
            $I->getPublicScenario()->skip('Skip for production!');
        }

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
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
                'location' => [
                    'id' => self::$location['A']
                ]
            ],
            [
                'user_id' => self::$userId,
                'location' => [
                    'id' => self::$location['B']
                ]
            ]
        ]);
    }

    public function doubleEmptyBeaconTest(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
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
                'location' => [
                    'id' => self::$location['A']
                ]
            ]
        ]);
    }

    public function doubleBeaconTest(ApiTester $I)
    {
        if ('production' === $I->getEnv()) {
            $I->getPublicScenario()->skip('Skip for production!');
        }

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
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
                'location' => [
                    'id' => self::$location['A']
                ]
            ],
            [
                'user_id' => self::$userId,
                'location' => [
                    'id' => self::$location['B']
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
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
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
                        'X-User-Id' => self::$userId
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
