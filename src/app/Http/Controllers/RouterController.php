<?php

namespace App\Http\Controllers;

use App\Router;
use Illuminate\Http\JsonResponse;

/**
 * #OA\Get(
 *     tags={"Router"},
 *     path="/api/v1/routers",
 *     description="Returns all routers",
 *     #OA\Parameter(
 *         name="limit",
 *         in="query",
 *         description="maximum number of results to return",
 *         required=false,
 *         #OA\Schema(
 *             type="integer",
 *             format="int32"
 *         )
 *     ),
 *     #OA\Response(
 *         response=200,
 *         description="Router response",
 *         #OA\JsonContent(
 *             type="array",
 *             #OA\Items(ref="#/components/schemas/Router")
 *         ),
 *     ),
 * )
 */

/**
 * #OA\Get(
 *     tags={"Router"},
 *     path="/api/v1/routers/{id}",
 *     description="Returns a router based on a single ID",
 *     operationId="getRouter",
 *     #OA\Parameter(
 *         description="ID of router to fetch",
 *         in="path",
 *         name="id",
 *         required=true,
 *         #OA\Schema(
 *             type="integer",
 *             format="int64",
 *         )
 *     ),
 *     #OA\Response(
 *         response=200,
 *         description="Router response",
 *         #OA\JsonContent(ref="#/components/schemas/Router"),
 *     ),
 *     #OA\Response(
 *         response=404,
 *         description="unexpected error",
 *         #OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */

/**
 * #OA\Post(
 *     tags={"Router"},
 *     path="/api/v1/routers",
 *     operationId="createRouter",
 *     description="Creates a new router.",
 *     #OA\RequestBody(
 *         description="Router to add.",
 *         required=true,
 *         #OA\MediaType(
 *             mediaType="application/json",
 *             #OA\Schema(ref="#/components/schemas/NewRouter")
 *         )
 *     ),
 *     #OA\Response(
 *         response=200,
 *         description="Router response",
 *         #OA\JsonContent(ref="#/components/schemas/Router")
 *     ),
 *     #OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         #OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 * )
 */

/**
 * #OA\Put(
 *     tags={"Router"},
 *     path="/api/v1/routers/{id}",
 *     description="Update a router based on a single ID.",
 *     operationId="updateRouter",
 *     #OA\Parameter(
 *         description="ID of router to fetch",
 *         in="path",
 *         name="id",
 *         required=true,
 *         #OA\Schema(
 *             type="integer",
 *             format="int64",
 *         )
 *     ),
 *     #OA\RequestBody(
 *         description="Router to update.",
 *         required=true,
 *         #OA\MediaType(
 *             mediaType="application/json",
 *             #OA\Schema(ref="#/components/schemas/NewRouter")
 *         )
 *     ),
 *     #OA\Response(
 *         response=200,
 *         description="Router response",
 *         #OA\JsonContent(ref="#/components/schemas/Router"),
 *     ),
 *     #OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         #OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */

/**
 * #OA\Delete(
 *     tags={"Router"},
 *     path="/api/v1/routers/{id}",
 *     description="Deletes a single router based on the ID.",
 *     operationId="deleteRouter",
 *     #OA\Parameter(
 *         description="ID of router to delete",
 *         in="path",
 *         name="id",
 *         required=true,
 *         #OA\Schema(
 *             format="int64",
 *             type="integer"
 *         )
 *     ),
 *     #OA\Response(
 *         response=204,
 *         description="Router deleted"
 *     ),
 *     #OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         #OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */
class RouterController extends Controller
{
    use Traits\CrudTrait;
    
    const MODEL = Router::class;

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
