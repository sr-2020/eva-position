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
     * Check user credentials
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
        if (!Hash::check($request->input('password'), $user->password)) {
            return new JsonResponse([], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $apikey = base64_encode(str_random(32));
        User::where('email', $request->input('email'))->update(['api_key' => $apikey]);

        return new JsonResponse([
            'api_key' => $apikey
        ], JsonResponse::HTTP_OK);
    }
}
