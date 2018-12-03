<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    $created_at = fakeDateTime();

    return [
        'body' => $faker->sentence(),
        'created_at' => $created_at,
        'updated_at' => $created_at,
    ];
});
