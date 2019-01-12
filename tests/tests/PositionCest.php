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

        static::$before = true;
    }

    public function indexTest(ApiTester $I)
    {
        $I->sendGET(self::$route);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([]);
    }

    public function createTest(ApiTester $I)
    {
        $routers = [
            [
                'ssid' => 'room_a',
                'bssid' => '00:0a:95:9d:00:0a',
                'level' => -20
            ],
            [
                'ssid' => 'room_b',
                'bssid' => '00:0a:95:9d:00:0b',
                'level' => -60
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

        $jsonResponse = json_decode($I->grabResponse());
        self::$createdId = $jsonResponse->id;
    }

}
