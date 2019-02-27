<?php

namespace App\Http\Controllers;

use App\Beacon;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     tags={"Beacon"},
 *     path="/api/v1/beacons",
 *     description="Returns all beacons",
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
 *         description="Beacon response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Beacon")
 *         ),
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     tags={"Beacon"},
 *     path="/api/v1/beacons/{id}",
 *     description="Returns a beacon based on a single ID",
 *     operationId="getBeacon",
 *     @OA\Parameter(
 *         description="ID of beacon to fetch",
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
 *         description="Beacon response",
 *         @OA\JsonContent(ref="#/components/schemas/Beacon"),
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
 *     tags={"Beacon"},
 *     path="/api/v1/beacons",
 *     operationId="createBeacon",
 *     description="Creates a new beacon.",
 *     @OA\RequestBody(
 *         description="Beacon to add.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewBeacon"),
 *             example={"label": "room1", "ssid": "beacon1", "bssid":"c0:0a:95:9d:00:0c"}
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Beacon response",
 *         @OA\JsonContent(ref="#/components/schemas/Beacon")
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 * )
 */

/**
 * @OA\Put(
 *     tags={"Beacon"},
 *     path="/api/v1/beacons/{id}",
 *     description="Update a beacon based on a single ID.",
 *     operationId="updateBeacon",
 *     @OA\Parameter(
 *         description="ID of beacon to fetch",
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
 *         description="Beacon to update.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewBeacon")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Beacon response",
 *         @OA\JsonContent(ref="#/components/schemas/Beacon"),
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */

/**
 * @OA\Delete(
 *     tags={"Beacon"},
 *     path="/api/v1/beacons/{id}",
 *     description="Deletes a single beacon based on the ID.",
 *     operationId="deleteBeacon",
 *     @OA\Parameter(
 *         description="ID of beacon to delete",
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
 *         description="Beacon deleted",
 *         @OA\Schema(
 *             type=null
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */
class BeaconController extends Controller
{
    use Traits\CrudTrait;
    
    const MODEL = Beacon::class;

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
