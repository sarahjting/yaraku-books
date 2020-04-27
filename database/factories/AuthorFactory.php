<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Author::class, function (Faker $faker) {
    return [
        "given_name" => $faker->firstName(),
        "family_name" => $faker->lastName(),
    ];
});
