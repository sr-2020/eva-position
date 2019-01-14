<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    const MODEL = User::class;

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

        $apikey = base64_encode(str_random(32));
        $user->api_key = $apikey;
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
                'api_key' => base64_encode(str_random(32)),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST);
        }

        $user->setVisible(['id', 'api_key']);
        return new JsonResponse($user->toArray(), JsonResponse::HTTP_OK);
    }
}
