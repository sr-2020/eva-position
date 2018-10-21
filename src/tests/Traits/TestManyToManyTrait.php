<?php

use Illuminate\Http\JsonResponse;

trait TestManyToManyTrait
{
    /**
     * Create master model factory.
     *
     * @return \Laravel\Lumen\Application
     */
    protected function makeMasterFactory()
    {
        $controller = static::CONTROLLER;
        return factory($controller::MODEL)->make();
    }

    /**
     * Create slave model factory.
     *
     * @return \Laravel\Lumen\Application
     */
    protected function makeSlaveFactory()
    {
        $controller = static::CONTROLLER;
        $masterModel = factory($controller::MODEL)->make();
        $method = $controller::METHOD;
        $relations = $masterModel->$method();
        $slaveModelClass = get_class($relations->getRelated());
        
        return factory($slaveModelClass)->make();
    }

    /**
     * Get relations model method.
     *
     * @return \Laravel\Lumen\Application
     */
    protected function getRelationsMethod()
    {
        $controller = static::CONTROLLER;
        return $controller::METHOD;
    }

    /**
     * A basic test index.
     *
     * @return void
     */
    public function testIndex()
    {
        $masterModel = $this->makeMasterFactory();
        $masterModel->save();

        $slaveModel = $this->makeSlaveFactory();
        $slaveModel->save();

        $method = $this->getRelationsMethod();
        $masterModel->$method()->attach($slaveModel->id);

        $this->json('GET', static::ROUTE . '/' . $masterModel->id . '/' . $method)
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJson([$slaveModel->toArray()]);
    }    

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreate()
    {
        $masterModel = $this->makeMasterFactory();
        $masterModel->save();

        $slaveModel = $this->makeSlaveFactory();
        $slaveModel->save();

        $method = $this->getRelationsMethod();
        $this->json('POST', static::ROUTE . '/' . $masterModel->id . '/' . $method . '/' . $slaveModel->id)
            ->seeStatusCode(JsonResponse::HTTP_CREATED);
    }

    /**
     * A basic test read.
     *
     * @return void
     */
    public function testRead()
    {
        $masterModel = $this->makeMasterFactory();
        $masterModel->save();

        $slaveModel = $this->makeSlaveFactory();
        $slaveModel->save();

        $method = $this->getRelationsMethod();
        $masterModel->$method()->attach($slaveModel->id);

        $this->json('GET', static::ROUTE . '/' . $masterModel->id . '/' . $method . '/' . $slaveModel->id)
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJson([$slaveModel->toArray()]);
    }

    /**
     * A basic test delete.
     *
     * @return void
     */
    public function testDelete()
    {
        $masterModel = $this->makeMasterFactory();
        $masterModel->save();

        $slaveModel = $this->makeSlaveFactory();
        $slaveModel->save();

        $method = $this->getRelationsMethod();
        $masterModel->$method()->attach($slaveModel->id);

        $this->json('DELETE', static::ROUTE . '/' . $masterModel->id . '/' . $method . '/' . $slaveModel->id)
            ->seeStatusCode(JsonResponse::HTTP_NO_CONTENT)
            ->seeJson([]);
    }
}
