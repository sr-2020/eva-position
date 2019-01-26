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
     * @param string $file
     * @return integer
     */
    protected function getFrequency($file)
    {
        $filePath = storage_path('app/public/' . $file);

        $result = shell_exec("sox {$filePath} -n trim 0 1 stat -freq -v 2>&1 | cat");

        $array = [];
        $lines = explode(PHP_EOL, $result);

        if (2 >= count($lines)) {
            return -1;
        }

        foreach ($lines as $line) {
            $pair = explode(' ', $line);
            if (!empty($pair[2])) {
                $array[$pair[0]] = $pair[2];
            }
        }

        $highArray = array_filter($array, function($item) {
            return $item > 17000;
        }, ARRAY_FILTER_USE_KEY);

        $highArray = array_filter($highArray, function($item) {
            return $item > 1000;
        });

        if (0 === count($highArray)) {
            return 0;
        }

        arsort($highArray);
        return round(key($highArray));
    }

    /**
     * @param string $file
     * @return void
     */
    protected function saveSpectogram($file)
    {
        $filePath = storage_path('app/public/' . $file);
        $filePathPng = str_replace('.wav', '.png', $filePath);

        shell_exec("sox {$filePath} -n spectrogram -o {$filePathPng}");
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
            $model->filename = $fileName;
            $model->frequency = self::getFrequency($fileName);
            $user = $request->user();
            $model->user_id = $user->id;
            $model->save();
            self::saveSpectogram($fileName);
        }

        return new JsonResponse($model, JsonResponse::HTTP_CREATED);
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
