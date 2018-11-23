<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    $sentence = $faker->sentence();
    $created_at = fakeDateTime();

    return [
        'title' => $sentence,
        'body' => $faker->text(),
        'excerpt' => $sentence,
        'created_at' => fakeDateTime(),
        'updated_at' => fakeDateTime($created_at),
    ];
});
