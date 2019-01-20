<?php

namespace App\Http\Controllers;

use App\Audio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Get(
 *     tags={"Audio"},
 *     path="/api/v1/audios",
 *     description="Returns all audios",
 *     @OA\Parameter(
 *         name="limit",
 *         in="query",
 *         description="maximum number of results to return",
 *         required=false,
 *         @OA\Schema(
 *             type="integer",
 *             format="int32"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Audio response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Audio")
 *         ),
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     tags={"Audio"},
 *     path="/api/v1/audios/{id}",
 *     description="Returns a audio based on a single ID",
 *     operationId="getAudio",
 *     @OA\Parameter(
 *         description="ID of audio to fetch",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             format="int64",
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Audio response",
 *         @OA\JsonContent(ref="#/components/schemas/Audio"),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */

/**
 * @OA\Post(
 *     tags={"Audio"},
 *     path="/api/v1/audios",
 *     operationId="createAudio",
 *     description="Creates a new audio.",
 *     @OA\RequestBody(
 *         description="Audio to add.",
 *         required=true,
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Audio response",
 *         @OA\JsonContent(ref="#/components/schemas/Audio")
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 * )
 */

/**
 * @OA\Delete(
 *     tags={"Audio"},
 *     path="/api/v1/audios/{id}",
 *     description="Deletes a single audio based on the ID.",
 *     operationId="deleteAudio",
 *     @OA\Parameter(
 *         description="ID of audio to delete",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(
 *             format="int64",
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Audio deleted"
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */
class AudioController extends Controller
{
    const MODEL = Audio::class;

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
        $model = $modelClass::create($request->all());

        if ($request->hasFile('audio')) {
            $file = $request->file('audio');
            $fileName = $model->id . '.' . $file->getClientOriginalExtension();
            Storage::put($fileName, $file->get());
        }

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

        $contents = Storage::get($model->id . '.txt');
        var_dump($contents);
        exit;

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
