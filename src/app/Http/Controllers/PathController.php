<?php

namespace App\Http\Controllers;

use App\Path;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     tags={"Path"},
 *     path="/api/v1/paths",
 *     description="Returns all paths",
 *     @OA\Parameter(
 *         name="limit",
 *         in="query",
 *         example="10",
 *         description="maximum number of results to return",
 *         required=false,
 *         @OA\Schema(
 *             type="integer",
 *             format="int32",
 *             default="100"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Path response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Path")
 *         ),
 *     ),
 * )
 */

class PathController extends Controller
{
    use Traits\CrudTrait;

    const MODEL = Path::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function users()
    {
        $modelClass = self::MODEL;
        $list = $modelClass::has('users')->get()->makeVisible('users');
        return new JsonResponse($list, JsonResponse::HTTP_OK);
    }
}
