<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     tags={"Profile"},
 *     path="/api/v1/profile",
 *     description="Returns a user info which auth for token",
 *     operationId="profileUser",
 *     @OA\Response(
 *         response=200,
 *         description="User response",
 *         @OA\JsonContent(ref="#/components/schemas/User"),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */

/**
 * @OA\Put(
 *     tags={"Profile"},
 *     path="/api/v1/profile",
 *     operationId="updateProfile",
 *     description="Register new user.",
 *     @OA\RequestBody(
 *         description="Creds for registeration.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/User"),
 *             example={"email": "test@email.com", "password": "secret", "name": "Tim Cook"}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Register user",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 *     security={
 *         {"bearerAuth": {}}
 *     }
 * )
 */

class ProfileController extends Controller
{
    const MODEL = User::class;

    /**
     * Get user auth info
     *
     * @return JsonResponse
     */
    public function read(Request $request)
    {
        $user = $request->user();
        $model= User::with('beacon')->findOrFail($user->id)->makeVisible('beacon');
        return new JsonResponse($model, JsonResponse::HTTP_OK);
    }

    /**
     * Update user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $modelClass = self::MODEL;
        $user = $request->user();

        $model= $modelClass::findOrFail($user->id);
        $model->fill($request->all());
        $model->save();
        return new JsonResponse($model, JsonResponse::HTTP_OK);
    }
}
