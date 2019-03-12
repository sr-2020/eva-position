<?php 

class BeaconCest
{
    static protected $createdId = 0;
    static protected $route = '/beacons';

    public function indexTest(ApiTester $I)
    {
        $I->sendGET(self::$route);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([]);
    }

    public function createTest(ApiTester $I)
    {
        $label = 'Human Label';
        $name = 'Beacon Test';
        $bssid = '00:0a:95:9d:68:16';
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Token ' . $I->getAdminToken());
        $I->sendPOST(self::$route, [
            'label' => $label,
            'ssid' => $name,
            'bssid' => $bssid
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'ssid' => 'string',
            'label' => 'string',
        ]);
        $I->canSeeResponseContainsJson([
            'ssid' => $name,
            'label' => $label,
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
            'ssid' => 'string',
            'label' => 'string',
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId
        ]);
    }

    public function updateTest(ApiTester $I)
    {
        $label = 'Human Label New';
        $name = 'Beacon Test New';
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Token ' . $I->getAdminToken());
        $I->sendPUT(self::$route . '/'  . self::$createdId, [
            'ssid' => $name,
            'label' => $label,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'ssid' => 'string',
            'label' => 'string',
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId,
            'ssid' => $name,
            'label' => $label,
        ]);
    }    

    public function deleteTest(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', 'Token ' . $I->getAdminToken());
        $I->sendDELETE(self::$route . '/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NO_CONTENT);
    }
    
    public function tryReadTest(ApiTester $I)
    {
        $I->sendGET(self::$route . '/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND);
    }
}
