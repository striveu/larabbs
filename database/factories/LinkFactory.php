<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Link::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'link' => $faker->url,
    ];
});
