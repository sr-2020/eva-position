<?php

namespace App\Http\Controllers;

use App\Path;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $modelClass = self::MODEL;
        $query = $modelClass::with('beacon');
        self::applyQuery($request, $query);
        $list = $query->get()->makeVisible('beacon');
        return new JsonResponse($list, JsonResponse::HTTP_OK);
    }
}
