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
        $rnd = md5(microtime());
        $label = 'Human Label';
        $name = 'Beacon Test';
        $bssid = sprintf('00:0a:95:9d:%s:%s', substr($rnd, 0, 2), substr($rnd, 2, 2));
        $location_id = 1;
        $lat = -30.3;
        $lng = 20.2;
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
        $I->sendPOST(self::$route, [
            'label' => $label,
            'ssid' => $name,
            'bssid' => $bssid,
            'location_id' => $location_id,
            'lat' => $lat,
            'lng' => $lng,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'ssid' => 'string',
            'label' => 'string',
            'location_id' => 'integer',
            'lat' => 'float',
            'lng' => 'float',
        ]);
        $I->canSeeResponseContainsJson([
            'ssid' => $name,
            'label' => $label,
            'location_id' => $location_id,
            'lat' => $lat,
            'lng' => $lng,
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
            'location_id' => 'integer',
            'lat' => 'float',
            'lng' => 'float',
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId
        ]);
    }

    public function updateTest(ApiTester $I)
    {
        $label = 'Human Label New';
        $name = 'Beacon Test New';
        $lat = -90.3;
        $lng = 80.2;
        $location_id = 2;
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
        $I->sendPUT(self::$route . '/'  . self::$createdId, [
            'ssid' => $name,
            'label' => $label,
            'location_id' => $location_id,
            'lat' => $lat,
            'lng' => $lng,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'ssid' => 'string',
            'label' => 'string',
            'location_id' => 'integer',
            'lat' => 'float',
            'lng' => 'float',
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId,
            'ssid' => $name,
            'label' => $label,
            'location_id' => $location_id,
            'lat' => $lat,
            'lng' => $lng,
        ]);
    }

    public function deleteTest(ApiTester $I)
    {
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
        $I->sendDELETE(self::$route . '/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NO_CONTENT);
    }

    public function tryReadTest(ApiTester $I)
    {
        $I->sendGET(self::$route . '/' . self::$createdId);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND);
    }
}
