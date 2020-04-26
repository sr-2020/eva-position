<?php

namespace App\Http\Controllers;

use App\Layer;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Get(
 *     tags={"Layer"},
 *     path="/api/v1/layers",
 *     description="Returns all Layers",
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
 *         description="Layer response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Layer")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Layer bad request",
 *         @OA\JsonContent(
 *             type="object"
 *         ),
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     tags={"Layer"},
 *     path="/api/v1/layers/{id}",
 *     description="Returns a Layer based on a single ID",
 *     operationId="getLayer",
 *     @OA\Parameter(
 *         description="ID of Layer to fetch",
 *         in="path",
 *         name="id",
 *         required=true,
 *         example=1,
 *         @OA\Schema(
 *             type="integer",
 *             format="int64",
 *             default="1"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Layer response",
 *         @OA\JsonContent(ref="#/components/schemas/Layer"),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Layer bad request",
 *         @OA\JsonContent(
 *             type="object"
 *         ),
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
 *     tags={"Layer"},
 *     path="/api/v1/layers",
 *     operationId="createLayer",
 *     description="Creates a new Layer.",
 *     @OA\RequestBody(
 *         description="Layer to add.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewLayer"),
 *             example={"label": "room1", "ssid": "Layer1", "bssid":"c0:0a:95:9d:00:0c", "location_id": 1, "lat":50.5, "lng":-70.7}
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Layer response",
 *         @OA\JsonContent(ref="#/components/schemas/Layer")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Layer bad request",
 *         @OA\JsonContent(
 *             type="object"
 *         ),
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 *      security={
 *         {"ApiKeyAuth": {"1"}}
 *     }
 * )
 */

/**
 * @OA\Put(
 *     tags={"Layer"},
 *     path="/api/v1/layers/{id}",
 *     description="Update a Layer based on a single ID.",
 *     operationId="updateLayer",
 *     @OA\Parameter(
 *         description="ID of Layer to fetch",
 *         in="path",
 *         name="id",
 *         required=true,
 *         example=1,
 *         @OA\Schema(
 *             type="integer",
 *             format="int64",
 *             default="1"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Layer to update.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewLayer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Layer response",
 *         @OA\JsonContent(ref="#/components/schemas/Layer"),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Layer bad request",
 *         @OA\JsonContent(
 *             type="object"
 *         ),
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 *     security={
 *         {"ApiKeyAuth": {"1"}}
 *     }
 * )
 */

/**
 * @OA\Delete(
 *     tags={"Layer"},
 *     path="/api/v1/layers/{id}",
 *     description="Deletes a single Layer based on the ID.",
 *     operationId="deleteLayer",
 *     @OA\Parameter(
 *         description="ID of Layer to delete",
 *         in="path",
 *         name="id",
 *         required=true,
 *         example=2,
 *         @OA\Schema(
 *             format="int64",
 *             type="integer",
 *             default=2
 *         )
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Layer deleted",
 *         @OA\Schema(
 *             type=null
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Layer bad request",
 *         @OA\JsonContent(
 *             type="object"
 *         ),
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 *     security={
 *         {"ApiKeyAuth": {"1"}}
 *     }
 * )
 */
class LayerController extends Controller
{
    use Traits\CrudTrait;
    
    const MODEL = Layer::class;
}
