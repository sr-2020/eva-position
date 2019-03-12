<?php 

class UserItemCest
{
    use Helper\ManyToManyTrait;

    static protected $createdId = 0;
    static protected $createdSubs = [];

    static protected $countItems = 3;

    static protected $route = '/users';
    static protected $subroute = '/items';
    
    static protected $before = false;

    public function _before(\ApiTester $I)
    {
        if (static::$before) {
            return ;
        }
        $faker = Faker\Factory::create();
        $data = [
            'name' => 'User Test',
            'email' => $faker->email,
            'password' => 'secret'
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Token ' . $I->getAdminToken());
        $I->sendPOST(self::$route, $data);
        $jsonResponse = json_decode($I->grabResponse());
        self::$createdId = $jsonResponse->id;

        for ($i = 0; $i < self::$countItems; $i++) {
            $name = 'Sub Test' . $i;
            $I->haveHttpHeader('Content-Type', 'application/json');
            $I->haveHttpHeader('Authorization', 'Token ' . $I->getAdminToken());
            $I->sendPOST(self::$subroute, ['name' => $name]);
            $jsonResponse = json_decode($I->grabResponse(), true);
            self::$createdSubs[] = $jsonResponse;
        }
        static::$before = true;
    }

}
