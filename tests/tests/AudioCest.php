<?php 

class AudioCest
{
    static protected $apiKey = '';
    static protected $createdId = 0;
    static protected $route = '/audios';

    static protected $before = false;

    public function _before(\ApiTester $I, $scenario)
    {
        $scenario->skip('Temporary skip for docker image');
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

    public function firstRouterTest(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', self::$apiKey);
        $I->sendPOST(self::$route, [], [
            'audio' => codecept_data_dir('audio20100.wav')
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'filename' => 'string',
            'frequency' => 'integer'
        ]);
        $I->seeResponseContainsJson([
            'frequency' => 20101
        ]);
    }

    public function secondRouterTest(ApiTester $I)
    {
        $I->haveHttpHeader('Authorization', self::$apiKey);
        $I->sendPOST(self::$route, [], [
            'audio' => codecept_data_dir('audio23100.wav')
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'filename' => 'string',
            'frequency' => 'integer'
        ]);
        $I->seeResponseContainsJson([
            'frequency' => 23098
        ]);
    }
}
