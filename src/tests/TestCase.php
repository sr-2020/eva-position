<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    protected static $userId = 1;

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
    }
}
