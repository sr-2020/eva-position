<?php

use App\Http\Controllers\AudioController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile as UpFile;

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
        $user = factory(App\User::class)->make();
        $user->save();

        $path = base_path('tests/data/audio20100.wav');
        $file = new UploadedFile($path, 'test.wav', null, null, true);

        $this->call('POST', static::ROUTE, [], [], [
            'audio' => $file
        ], [
            'HTTP_Authorization' => $user->api_key
        ]);

        $this->seeStatusCode(JsonResponse::HTTP_CREATED)
            ->seeJsonEquals([
                'id' => 1,
                'filename' => '1.wav',
                'frequency' => 20101,
                'user_id' => 1
            ]);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateSecondSuccess()
    {
        $user = factory(App\User::class)->make();
        $user->save();

        $path = base_path('tests/data/audio23100.wav');
        $file = new UploadedFile($path, 'test.wav', null, null, true);

        $this->call('POST', static::ROUTE, [], [], [
            'audio' => $file
        ], [
            'HTTP_Authorization' => $user->api_key
        ]);

        $this->seeStatusCode(JsonResponse::HTTP_CREATED)
            ->seeJsonEquals([
                'id' => 1,
                'filename' => '1.wav',
                'frequency' => 23098,
                'user_id' => 1
            ]);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreateUnauthorized()
    {
        $model = $this->makeFactory();
        $this->json('POST', static::ROUTE, $model->toArray(), [
            'Authorization' => 'token'
        ])
            ->seeStatusCode(JsonResponse::HTTP_UNAUTHORIZED);
    }
}
