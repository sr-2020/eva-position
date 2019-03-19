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
        'amount' => $faker->numberBetween(0, 1000),
        'status' => $faker->safeColorName,
        'beacon_id' => null,
        'location_id' => null,
    ];
});

$factory->define(App\Path::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'beacon_id' => 1,
    ];
});

$factory->define(App\Beacon::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->streetName,
        'ssid' => $faker->slug,
        'bssid' => $faker->macAddress,
    ];
});

$factory->define(App\Location::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->streetName,
    ];
});

$factory->define(App\Position::class, function (Faker\Generator $faker) {
    return [
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
