<?php

use App\Http\Controllers\UserController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Illuminate\Http\JsonResponse;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    const CONTROLLER = UserController::class;

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
     * A basic test login success.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $password = 'pass';
        $model = $this->makeFactory();
        $model->password = $password;
        $model->save();

        $this->json('POST', '/api/v1/login', [
            'email' => $model->email,
            'password' => $password
        ])
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJsonStructure([
                'api_key'
            ]);
    }

    /**
     * A basic test login failed.
     *
     * @return void
     */
    public function testLoginFailed()
    {
        $password = 'pass';
        $model = $this->makeFactory();
        $model->password = $password;
        $model->save();

        $this->json('POST', '/api/v1/login', [
            'email' => $model->email,
            'password' => 'password'
        ])
            ->seeStatusCode(JsonResponse::HTTP_UNAUTHORIZED)
            ->seeJsonStructure([]);
    }

    /**
     * A basic test login success.
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
        $model = $this->makeFactory();
        $this->json('POST', '/api/v1/register', [
            'email' => $model->email,
            'password' => 'pass'
        ])
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJsonStructure([
                'id',
                'api_key'
            ]);

        $this->json('POST', '/api/v1/login', [
            'email' => $model->email,
            'password' => 'pass'
        ])
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJsonStructure([
                'api_key'
            ]);
    }

    /**
     * A basic test login failed.
     *
     * @return void
     */
    public function testRegisterFailed()
    {
        $model = $this->makeFactory();
        $this->json('POST', '/api/v1/register', [
            'email' => $model->email,
            'password' => ''
        ])
            ->seeStatusCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->seeJsonStructure([]);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testProfileAuthorizationSuccess()
    {
        $model = $this->makeFactory();
        $user = factory(App\User::class)->make();
        $user->save();

        $this->json('GET', '/api/v1/profile', $model->toArray(), [
            'Authorization' => $user->api_key
        ])
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJsonEquals($user->toArray()+ ['beacon' => null]);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testProfileBearerAuthorizationSuccess()
    {
        $model = $this->makeFactory();
        $user = factory(App\User::class)->make();
        $user->save();

        $this->json('GET', '/api/v1/profile', $model->toArray(), [
            'Authorization' => 'Bearer ' . $user->api_key
        ])
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJsonEquals($user->toArray() + ['beacon' => null]);
    }
    /**
     * A basic test create.
     *
     * @return void
     */
    public function testProfileAuthorizationFail()
    {
        $model = $this->makeFactory();
        $user = factory(App\User::class)->make();
        $user->save();

        $this->json('GET', '/api/v1/profile', $model->toArray(), [
            'Authorization' => 'Bearer test'
        ])
            ->seeStatusCode(JsonResponse::HTTP_UNAUTHORIZED);
    }
}
