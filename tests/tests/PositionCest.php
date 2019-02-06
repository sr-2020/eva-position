<?php 

class PositionCest
{
    static protected $apiKey = '';
    static protected $createdId = 0;
    static protected $route = '/positions';

    static protected $before = false;

    public function _before(\ApiTester $I)
    {
        if (static::$before) {
            return ;
        }
        $data = [
            'name' => 'User Test',
            'email' => 'test@email.com',
            'password' => 'secret'
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/users', $data);

        $data = [
            'email' => 'test@email.com',
            'password' => 'secret'
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/login', $data);
        $jsonResponse = json_decode($I->grabResponse());
        self::$apiKey = $jsonResponse->api_key;
        self::$createdId = $jsonResponse->id;

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
            [
                'ssid' => 'broom_a',
                'bssid' => 'b0:0a:95:9d:00:0a',
                'level' => -10
            ],
            [
                'ssid' => 'broom_b',
                'bssid' => 'b0:0a:95:9d:00:0b',
                'level' => -30
            ]
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
                'bssid' => 'b0:0a:95:9d:00:0a'
            ]
        ]);
    }

    public function secondBeaconTest(ApiTester $I)
    {
        $beacons = [
            [
                'ssid' => 'broom_a',
                'bssid' => 'b0:0a:95:9d:00:0a',
                'level' => -50
            ],
            [
                'ssid' => 'broom_b',
                'bssid' => 'b0:0a:95:9d:00:0b',
                'level' => -30
            ]
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
                'bssid' => 'b0:0a:95:9d:00:0b'
            ]
        ]);
    }
}
