<?php

namespace App\Http\Controllers;

use App\Position;

/**
 * @OA\Get(
 *     tags={"Position"},
 *     path="/api/v1/positions",
 *     description="Returns all positions",
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
 *         description="Position response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Position")
 *         ),
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     tags={"Position"},
 *     path="/api/v1/positions/{id}",
 *     description="Returns a position based on a single ID",
 *     operationId="getPosition",
 *     @OA\Parameter(
 *         description="ID of position to fetch",
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
 *         description="Position response",
 *         @OA\JsonContent(ref="#/components/schemas/Position"),
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
 *     tags={"Position"},
 *     path="/api/v1/positions",
 *     operationId="createPosition",
 *     description="Creates a new position.",
 *     @OA\RequestBody(
 *         description="Position to add.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewPosition")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Position response",
 *         @OA\JsonContent(ref="#/components/schemas/Position")
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
 *     tags={"Position"},
 *     path="/api/v1/positions/{id}",
 *     description="Update a position based on a single ID.",
 *     operationId="updatePosition",
 *     @OA\Parameter(
 *         description="ID of position to fetch",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             format="int64",
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Position to update.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewPosition")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Position response",
 *         @OA\JsonContent(ref="#/components/schemas/Position"),
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
 *     tags={"Position"},
 *     path="/api/v1/positions/{id}",
 *     description="Deletes a single position based on the ID.",
 *     operationId="deletePosition",
 *     @OA\Parameter(
 *         description="ID of position to delete",
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
 *         description="Position deleted"
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */
class PositionController extends Controller
{
    use Traits\CrudTrait;
    
    const MODEL = Position::class;
}
