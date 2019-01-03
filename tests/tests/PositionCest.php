<?php 

class PositionCest
{
    static protected $createdId = 0;
    static protected $route = '/positions';

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
                'name' => 'room_a',
                'bssid' => '00:0a:95:9d:00:0a',
                'level' => -20
            ],
            [
                'name' => 'room_b',
                'bssid' => '00:0a:95:9d:00:0b',
                'level' => -60
            ]
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
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
    
    public function readTest(ApiTester $I)
    {
        $I->sendGET(self::$route . '/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'routers' => 'array'
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId
        ]);
    }

    public function deleteTest(ApiTester $I)
    {
        $I->sendDELETE(self::$route . '/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NO_CONTENT);
    }

    public function tryReadTest(ApiTester $I)
    {
        $I->sendGET(self::$route . '/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND);
    }
}
