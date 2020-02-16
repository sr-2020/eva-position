<?php

namespace App\Providers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $validator = Validator::make(['id' => $request->header('X-User-Id')], [
                'id' => 'required|integer|between:1,1000000000'
            ]);

            if ($validator->fails()) {
                return null;
            }

            if ($request->header('X-User-Id')) {
                $user = User::find($request->header('X-User-Id'));
                if (null === $user) {
                    $user = new User();
                    $user->id = $request->header('X-User-Id');
                    $user->save();
                    return $user;
                }
                return $user;
            }
        });
    }
}
