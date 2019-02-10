<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => $faker->password,
        'api_key' => $faker->randomAscii,
        'amount' => $faker->numberBetween(0, 1000),
        'status' => $faker->safeColorName,
        'sex' => $faker->randomElement(['female', 'male', 'unknown']),
        'router_id' => null,
        'beacon_id' => null,
    ];
});

$factory->define(App\Item::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->numberBetween(1, 10),
        'user_id' => 1,
        'shop_id' => 1,
    ];
});

$factory->define(App\Shop::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name
    ];
});

$factory->define(App\Path::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'beacon_id' => 1,
    ];
});

$factory->define(App\Router::class, function (Faker\Generator $faker) {
    return [
        'ssid' => $faker->slug,
        'bssid' => $faker->macAddress,
    ];
});

$factory->define(App\Beacon::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->streetName,
        'ssid' => $faker->slug,
        'bssid' => $faker->macAddress,
    ];
});

$factory->define(App\Position::class, function (Faker\Generator $faker) {
    return [
        'routers' => [
            [
                'ssid' => $faker->slug,
                'bssid' => $faker->macAddress,
                'level' => -($faker->randomDigit % 100)
            ],
            [
                'ssid' => $faker->slug,
                'bssid' => $faker->macAddress,
                'level' => -($faker->randomDigit % 100)
            ],
        ],
        'beacons' => [
            [
                'ssid' => $faker->slug,
                'bssid' => $faker->macAddress,
                'level' => -($faker->randomDigit % 100)
            ],
            [
                'ssid' => $faker->slug,
                'bssid' => $faker->macAddress,
                'level' => -($faker->randomDigit % 100)
            ],
        ],
    ];
});

$factory->define(App\Audio::class, function (Faker\Generator $faker) {
    return [
        'filename' => $faker->slug . '.txt',
        'user_id' => 1,
        'frequency' => $faker->randomDigit
    ];
});
