<?php

class UserCest
{
    static protected $createdId = 0;
    static protected $route = '/users';

    public function indexTest(ApiTester $I)
    {
        $I->sendGET(self::$route);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->canSeeResponseContainsJson([]);
    }

    public function createTest(ApiTester $I)
    {
        $data = [];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
        $I->sendPOST(self::$route, $data);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer'
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
            'id' => 'integer'
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId
        ]);
    }

    public function updateTest(ApiTester $I)
    {
        $name = 'User Test New';
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('X-User-Id', $I->getAdminId());
        $I->sendPUT(self::$route . '/'  . self::$createdId, ['name' => $name]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer'
        ]);
        $I->canSeeResponseContainsJson([
            'id' => self::$createdId
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
