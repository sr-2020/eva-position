<?php

use Illuminate\Http\JsonResponse;

trait TestCrudTrait
{
    /**
     * Create factory.
     *
     * @return \Laravel\Lumen\Application
     */
    protected function makeFactory()
    {
        $controller = static::Controller;
        $model = factory($controller::Model)->make();
        return $model;
    }

    /**
     * A basic test index.
     *
     * @return void
     */
    public function testIndex()
    {
        $model = $this->makeFactory();
        $model->save();

        $this->json('GET', static::Route)
            ->seeStatusCode(JsonResponse::HTTP_OK)
            ->seeJson([$model->toArray()]);
    }

    /**
     * A basic test create.
     *
     * @return void
     */
    public function testCreate()
    {
        $model = $this->makeFactory();
 
        $this->json('POST', static::Route, $model->toArray())
            ->seeStatusCode(JsonResponse::HTTP_CREATED)   
            ->seeJson($model->toArray());
    }

    /**
     * A basic test read.
     *
     * @return void
     */
    public function testRead()
    {
        $model = $this->makeFactory();
        $model->save();

        $this->json('GET', static::Route . '/' . $model->id)
            ->seeStatusCode(JsonResponse::HTTP_OK)   
            ->seeJson($model->toArray());
    }

    /**
     * A basic test update.
     *
     * @return void
     */
    public function testUpdate()
    {
        $model = $this->makeFactory();
        $model->save();

        $newModel = $this->makeFactory();

        $this->json('PUT', static::Route . '/' . $model->id, $newModel->toArray())
            ->seeStatusCode(JsonResponse::HTTP_OK)   
            ->seeJson($newModel->toArray());
    }

    /**
     * A basic test delete.
     *
     * @return void
     */
    public function testDelete()
    {
        $model = $this->makeFactory();
        $model->save();

        $this->json('DELETE', static::Route . '/' . $model->id)
            ->seeStatusCode(JsonResponse::HTTP_NO_CONTENT)   
            ->seeJson(null);
    }    
}
