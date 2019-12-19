<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     tags={"Location"},
 *     path="/api/v1/locations",
 *     description="Returns all locations",
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
 *         description="Location response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Location")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Location bad request",
 *         @OA\JsonContent(
 *             type="object"
 *         ),
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     tags={"Location"},
 *     path="/api/v1/locations/{id}",
 *     description="Returns a location based on a single ID",
 *     operationId="getLocation",
 *     @OA\Parameter(
 *         description="ID of location to fetch",
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
 *         description="Location response",
 *         @OA\JsonContent(ref="#/components/schemas/Location"),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Location bad request",
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
 *     tags={"Location"},
 *     path="/api/v1/locations",
 *     operationId="createLocation",
 *     description="Creates a new location.",
 *     @OA\RequestBody(
 *         description="Location to add.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewLocation"),
 *             example={"label": "room1", "ssid": "location1", "bssid":"c0:0a:95:9d:00:0c"}
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Location response",
 *         @OA\JsonContent(ref="#/components/schemas/Location")
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
 *     tags={"Location"},
 *     path="/api/v1/locations/{id}",
 *     description="Update a location based on a single ID.",
 *     operationId="updateLocation",
 *     @OA\Parameter(
 *         description="ID of location to fetch",
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
 *         description="Location to update.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewLocation")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Location response",
 *         @OA\JsonContent(ref="#/components/schemas/Location"),
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
 *     tags={"Location"},
 *     path="/api/v1/locations/{id}",
 *     description="Deletes a single location based on the ID.",
 *     operationId="deleteLocation",
 *     @OA\Parameter(
 *         description="ID of location to delete",
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
 *         description="Location deleted",
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
class LocationController extends Controller
{
    use Traits\CrudTrait;
    
    const MODEL = Location::class;

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
