<?php 

class LocationCest
{
    static protected $createdId = 0;
    static protected $route = '/locations';

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
        $polygon = [[10.3,20.1],[43.2,-34.2],[13.2,-14.2]];
        $options = ['a' => 1];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
        $I->sendPOST(self::$route, [
            'label' => $label,
            'polygon' => $polygon,
            'options' => $options,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'label' => 'string',
            'polygon' => 'array',
            'options' => 'array',
        ]);
        $I->canSeeResponseContainsJson([
            'label' => $label,
            'polygon' => $polygon,
            'options' => $options,
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
            'label' => 'string',
            'polygon' => 'array',
            'options' => 'array',
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId
        ]);
    }

    public function updateTest(ApiTester $I)
    {
        $label = 'Human Label New';
        $polygon = [[30.3,40.1],[23.2,-24.2],[13.2,-14.2]];
        $options = ['b' => 3];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
        $I->sendPUT(self::$route . '/'  . self::$createdId, [
            'label' => $label,
            'polygon' => $polygon,
            'options' => $options,
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'label' => 'string',
            'polygon' => 'array',
            'options' => 'array',
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId,
            'label' => $label,
            'polygon' => $polygon,
            'options' => $options,
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
