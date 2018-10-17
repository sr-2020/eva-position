<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Description of RestTrait
 *
 * @author ognestraz
 */
trait ManyToManyTrait
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $master_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($master_id)
    {
        $modelClass = static::Model;
        $method = static::Method;
        $model = $modelClass::findOrFail($master_id);
        $items = $model->$method()->get();
        return new JsonResponse($items, JsonResponse::HTTP_OK);
    }    

    /**
     * Attache a resource in model.
     *
     * @param  int  $master_id
     * @param  int  $slave_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function create($master_id, $slave_id)
    {
        $modelClass = static::Model;
        $method = static::Method;
        $model = $modelClass::findOrFail($master_id);
        $model->$method()->attach($slave_id);
        return new JsonResponse($model, JsonResponse::HTTP_CREATED);
    }

    /**
     * Show a resource in model.
     *
     * @param  int  $master_id
     * @param  int  $slave_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function read($master_id, $slave_id)
    {
        $modelClass = static::Model;
        $method = static::Method;
        $model = $modelClass::findOrFail($master_id);
        $relations = $model->$method();
        $item = $relations->where($relations->getRelatedPivotKeyName(), $slave_id)->get();
        return new JsonResponse($item, JsonResponse::HTTP_OK);
    }

    /**
     * Detache a resource in model.
     *
     * @param  int  $master_id
     * @param  int  $slave_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($master_id, $slave_id)
    {
        $modelClass = static::Model;
        $method = static::Method;
        $model = $modelClass::findOrFail($master_id);
        $model->$method()->detach($slave_id);
        return new JsonResponse($model, JsonResponse::HTTP_NO_CONTENT);
    }
}
