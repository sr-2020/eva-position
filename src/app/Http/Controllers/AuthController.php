<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Post(
 *     tags={"User"},
 *     path="/api/v1/login",
 *     operationId="loginUser",
 *     description="Login as user.",
 *     @OA\RequestBody(
 *         description="Creds for authorization.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/UserCreds")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Authorize user",
 *         @OA\JsonContent(ref="#/components/schemas/UserApiKey")
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 * )
 */

/**
 * @OA\Post(
 *     tags={"User"},
 *     path="/api/v1/register",
 *     operationId="registerUser",
 *     description="Register new user.",
 *     @OA\RequestBody(
 *         description="Creds for registeration.",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/UserCreds")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Register user",
 *         @OA\JsonContent(ref="#/components/schemas/UserApiKey")
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorModel"),
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     tags={"User"},
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

class AuthController extends Controller
{
    const MODEL = User::class;

    /**
     * Generate new api key
     * @return string
     */
    protected static function generationApiKey()
    {
        $apiKey = substr(base64_encode(str_random(64)), 0, 32);
        return $apiKey;
    }

    /**
     * Login method
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if (null === $user) {
            return new JsonResponse([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return new JsonResponse([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user->api_key = self::generationApiKey();
        $user->save();

        $user->setVisible(['id', 'api_key']);
        return new JsonResponse($user->toArray(), JsonResponse::HTTP_OK);
    }

    /**
     * Register method
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required',
            'password' => 'required'
        ]);

        try {
            $user = User::create([
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'name' => $request->input('name', ''),
                'api_key' => self::generationApiKey(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user->setVisible(['id', 'api_key']);
        return new JsonResponse($user->toArray(), JsonResponse::HTTP_OK);
    }

    /**
     * Get user auth info
     *
     * @return JsonResponse
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        $model= User::with('beacon')->findOrFail($user->id)->makeVisible('beacon');
        return new JsonResponse($model, JsonResponse::HTTP_OK);
    }
}
