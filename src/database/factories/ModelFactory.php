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
        'amount' => $faker->numberBetween(0, 1000)
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

$factory->define(App\Router::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'bssid' => $faker->macAddress,
    ];
});
