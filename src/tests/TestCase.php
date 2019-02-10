<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    protected static $apiKey = '';

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * Make seed
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');

        $user = App\User::find(1);
        self::$apiKey = $user->api_key;
    }
}
