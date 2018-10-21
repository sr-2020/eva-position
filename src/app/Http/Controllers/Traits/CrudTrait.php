<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Description of CrudTrait
 *
 * @author ognestraz
 */
trait CrudTrait
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $modelClass = self::MODEL;
        return new JsonResponse($modelClass::all(), JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $modelClass = self::MODEL;
        $model= $modelClass::create($request->all());
        return new JsonResponse($model, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function read($id)
    {
        $modelClass = self::MODEL;
        $model= $modelClass::findOrFail($id);
        return new JsonResponse($model, JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $modelClass = self::MODEL;
        $model= $modelClass::findOrFail($id);
        $model->fill($request->all());
        $model->save();
        return new JsonResponse($model, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $modelClass = self::MODEL;
        $model= $modelClass::findOrFail($id);
        $model->delete();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
