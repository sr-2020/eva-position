<?php 

class RouterCest
{
    static protected $createdId = 0;
    static protected $route = '/routers';

    public function indexTest(ApiTester $I)
    {
        $I->sendGET(self::$route);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([]);
    }

    public function createTest(ApiTester $I)
    {
        $name = 'Router Test';
        $bssid = '00:0a:95:9d:68:16';
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST(self::$route, [
            'name' => $name,
            'bssid' => $bssid
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'name' => 'string'
        ]);
        $I->canSeeResponseContainsJson([
            'name' => $name
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
            'name' => 'string'
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId
        ]);
    }

    public function updateTest(ApiTester $I)
    {
        $name = 'Router Test New';
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT(self::$route . '/'  . self::$createdId, ['name' => $name]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'name' => 'string'
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId,
            'name' => $name,
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
