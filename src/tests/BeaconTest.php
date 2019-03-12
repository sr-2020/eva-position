<?php

use App\Http\Controllers\BeaconController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\JsonResponse;

class BeaconTest extends TestCase
{
    use DatabaseMigrations;
    use TestCrudTrait;

    const ROUTE = '/api/v1/beacons';
    const CONTROLLER = BeaconController::class;

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateLowerBSSIDSuccess()
    {
        $model = $this->makeFactory();
        $lowerBssid = strtolower($model->bssid);
        $upperBssid = strtoupper($model->bssid);
        $model->bssid = $lowerBssid;
        $dataSend = array_merge($model->toArray(), [
            'bssid' => $lowerBssid
        ]);

        $this->json('POST', static::ROUTE, $dataSend, [
            'Authorization' => 'Token ' . self::getToken()
        ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED)
            ->seeJson($model->toArray());

        $json = json_decode($this->response->content());
        $this->assertEquals($upperBssid, $json->bssid);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateDoubleBssidFail()
    {
        $model = $this->makeFactory();
        $this->json('POST', static::ROUTE, $model->toArray(), [
            'Authorization' => 'Token ' . self::getToken()
        ])
            ->seeStatusCode(JsonResponse::HTTP_CREATED)
            ->seeJson($model->toArray());

        $this->json('POST', static::ROUTE, $model->toArray(), [
            'Authorization' => 'Token ' . self::getToken()
        ])
            ->seeStatusCode(JsonResponse::HTTP_BAD_REQUEST);
    }
}
