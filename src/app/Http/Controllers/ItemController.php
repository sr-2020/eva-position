<?php

namespace App\Http\Controllers;

use App\Item;

/**
 * @OA\Get(
 *     tags={"Item"},
 *     path="/api/v1/items",
 *     description="Returns all items",
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
 *         description="Item response",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Item")
 *         ),
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     tags={"Item"},
 *     path="/api/v1/items/{id}",
 *     description="Returns a item based on a single ID",
 *     operationId="getItem",
 *     @OA\Parameter(
 *         description="ID of item to fetch",
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
 *         description="Item response",
 *         @OA\JsonContent(ref="#/components/schemas/Item"),
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
 *     tags={"Item"},
 *     path="/api/v1/items",
 *     operationId="createItem",
 *     description="Creates a new item.",
 *     @OA\RequestBody(
 *         description="Item to add.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewItem")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Item response",
 *         @OA\JsonContent(ref="#/components/schemas/Item")
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
 *     tags={"Item"},
 *     path="/api/v1/items/{id}",
 *     description="Update a item based on a single ID.",
 *     operationId="updateItem",
 *     @OA\Parameter(
 *         description="ID of item to fetch",
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             format="int64",
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Item to update.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/NewItem")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Item response",
 *         @OA\JsonContent(ref="#/components/schemas/Item"),
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
 *     tags={"Item"},
 *     path="/api/v1/items/{id}",
 *     description="Deletes a single item based on the ID.",
 *     operationId="deleteItem",
 *     @OA\Parameter(
 *         description="ID of item to delete",
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
 *         description="Item deleted"
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     )
 * )
 */
class ItemController extends Controller
{
    use Traits\CrudTrait;

    const MODEL = Item::class;
}
