<?php

use App\Http\Controllers\AudioController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AudioTest extends TestCase
{
    use DatabaseMigrations;

    const ROUTE = '/api/v1/audios';
    const CONTROLLER = AudioController::class;

    /**
     * Create factory.
     *
     * @return \Laravel\Lumen\Application
     */
    protected function makeFactory()
    {
        $controller = static::CONTROLLER;
        $model = factory($controller::MODEL)->make();
        return $model;
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $model = $this->makeFactory();
        $user = factory(App\User::class)->make();
        $user->save();

        Storage::fake('avatars');
        $file = UploadedFile::fake()->create('sample.aac');

        $response = $this->call('POST', static::ROUTE, [

        ], [], [
            'audio' => $file
        ]);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
    }

    /**
     * A basic test create.
     *
     * @return void
     */
//    public function testCreateUnauthorized()
//    {
//        $model = $this->makeFactory();
//        $user = factory(App\User::class)->make();
//        $user->save();
//
//        $this->json('POST', static::ROUTE, $model->toArray(), [
//            'Authorization' => 'token'
//        ])
//            ->seeStatusCode(JsonResponse::HTTP_UNAUTHORIZED);
//    }
}
