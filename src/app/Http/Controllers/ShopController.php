<?php

namespace App\Http\Controllers;

use App\Shop;

/**
 * @OA\Get(
 *     tags={"Shop"},
 *     path="/api/v1/shops",
 *     description="Returns all shops",
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
 *         description="Shop response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Shop")
 *         ),
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     tags={"Shop"},
 *     path="/api/v1/shops/{id}",
 *     description="Returns a shop based on a single ID",
 *     operationId="getShop",
 *     @OA\Parameter(
 *         description="ID of shop to fetch",
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
 *         description="Shop response",
 *         @OA\JsonContent(ref="#/components/schemas/Shop"),
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
 *     tags={"Shop"},
 *     path="/api/v1/shops",
 *     operationId="createShop",
 *     description="Creates a new shop.",
 *     @OA\RequestBody(
 *         description="Shop to add.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewShop")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Shop response",
 *         @OA\JsonContent(ref="#/components/schemas/Shop")
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
 *     tags={"Shop"},
 *     path="/api/v1/shops/{id}",
 *     description="Update a shop based on a single ID.",
 *     operationId="updateShop",
 *     @OA\Parameter(
 *         description="ID of shop to fetch",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             format="int64",
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Shop to update.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewShop")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Shop response",
 *         @OA\JsonContent(ref="#/components/schemas/Shop"),
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
 *     tags={"Shop"},
 *     path="/api/v1/shops/{id}",
 *     description="Deletes a single shop based on the ID.",
 *     operationId="deleteShop",
 *     @OA\Parameter(
 *         description="ID of shop to delete",
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
 *         description="Shop deleted"
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */
class ShopController extends Controller
{
    use Traits\CrudTrait;
    
    const MODEL = Shop::class;
}
