<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Book::class, function (Faker $faker) {
    return [
        "title" => implode(" ", array_map('ucfirst', $this->faker->words(3))),
        "author_id" => function() {
            return factory(\App\Models\Author::class)->create();
        }
    ];
});

$factory->state(\App\Models\Book::class, "raw", function (Faker $faker) {
    return [
        "author" => [
            "name" => $faker->name()
        ],
    ];
});
