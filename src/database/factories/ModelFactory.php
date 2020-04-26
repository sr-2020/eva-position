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

use App\Location;
use Faker\Generator;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'location_id' => null,
    ];
});

$factory->define(App\Path::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'location_id' => 0,
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

$factory->define(App\Layer::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->colorName,
    ];
});
